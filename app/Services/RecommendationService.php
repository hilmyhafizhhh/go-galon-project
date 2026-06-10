<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RecommendationService
{
    /**
     * Entry point utama — dipanggil dari controller.
     * Otomatis memilih strategi: CBF atau Rule-Based.
     */
    public function recommend(string $userId, int $limit = 3): Collection
    {
        $history = $this->getUserHistory($userId);

        if ($history->isEmpty()) {
            // Cold start → Rule-Based
            return $this->ruleBasedRecommendation($limit);
        }

        // Returning user → CBF + Rule-Based sebagai booster
        return $this->contentBasedRecommendation($history, $userId, $limit);
    }

    // ──────────────────────────────────────────────────────────────
    // RULE-BASED RECOMMENDATION (cold start & booster)
    // ──────────────────────────────────────────────────────────────

    /**
     * Aturan (rules) yang digunakan:
     *   R1 — Produk wajib in-stock (stock > 0)
     *   R2 — Skor popularitas = jumlah unit terjual (order_items)
     *   R3 — Tie-breaker: harga lebih murah lebih diutamakan
     *   R4 — Produk baru (created < 7 hari) dapat boost +20%
     */
    public function ruleBasedRecommendation(int $limit = 3): Collection
    {
        $products = Product::withCount([
            // hitung total quantity yang pernah dipesan (popularity)
            'orderItems as total_ordered' => fn($q) =>
                $q->whereHas('order', fn($o) =>
                    $o->whereNotIn('status', ['draft', 'cancelled'])
                )
        ])
        ->where('stock', '>', 0)           // R1: hanya yang ada stok
        ->whereNull('deleted_at')
        ->get();

        return $products
            ->map(function (Product $p) {
                $score = $p->total_ordered ?? 0;

                // R4: new product boost (+20%)
                if ($p->created_at->gt(now()->subDays(7))) {
                    $score *= 1.20;
                }

                // R3: tie-breaker harga (semakin murah sedikit lebih tinggi)
                $score += (1 / max($p->price, 1)) * 0.001;

                $p->recommendation_score  = round($score, 4);
                $p->recommendation_reason = $this->ruleBasedReason($p);
                return $p;
            })
            ->sortByDesc('recommendation_score')
            ->take($limit)
            ->values();
    }

    private function ruleBasedReason(Product $p): string
    {
        if (($p->total_ordered ?? 0) === 0) {
            return 'Produk baru';
        }
        if ($p->created_at->gt(now()->subDays(7))) {
            return 'Baru & populer';
        }
        return 'Paling laris';
    }

    // ──────────────────────────────────────────────────────────────
    // CONTENT-BASED FILTERING
    // ──────────────────────────────────────────────────────────────

    /**
     * Fitur yang digunakan untuk CBF:
     *   - volume_l  (ukuran galon)
     *   - price     (harga)
     *
     * Profil user dibentuk dari rata-rata fitur produk yang pernah dibeli,
     * dibobot berdasarkan frekuensi pembelian (quantity).
     *
     * Similarity = cosine similarity antara vektor produk dan vektor profil user.
     * Final score = similarity + popularity_boost - bought_penalty
     */
    public function contentBasedRecommendation(
        Collection $history,
        string $userId,
        int $limit = 3
    ): Collection {
        $userVector  = $this->buildUserVector($history);
        $allProducts = Product::where('stock', '>', 0)->whereNull('deleted_at')->get();
        $boughtIds   = $history->pluck('product_id')->unique();

        $maxPrice  = $allProducts->max('price')    ?: 1;
        $maxVolume = $allProducts->max('volume_l') ?: 1;

        $scored = $allProducts->map(function (Product $p) use (
            $userVector, $maxPrice, $maxVolume, $boughtIds
        ) {
            $productVector   = $this->normalizeVector($p, $maxPrice, $maxVolume);
            $userVecNorm     = $this->normalizeUserVector($userVector, $maxPrice, $maxVolume);
            $similarity      = $this->cosineSimilarity($userVecNorm, $productVector);

            // Popularity booster (Rule-Based hybrid): +0 to +0.15
            $popularityBoost = min($p->orderItems()->count() / 100, 0.15);

            // Penalti kalau sudah pernah dibeli (prioritas turun, bukan di-exclude)
            $boughtPenalty   = $boughtIds->contains($p->id) ? 0.10 : 0;

            $finalScore = $similarity + $popularityBoost - $boughtPenalty;

            $p->recommendation_score  = round(max($finalScore, 0), 4);
            $p->recommendation_reason = $this->cbfReason($similarity, $popularityBoost);
            return $p;
        });

        $result = $scored->sortByDesc('recommendation_score')->take($limit)->values();

        // Fallback: tambal dari rule-based jika produk kurang
        if ($result->count() < $limit) {
            $existing = $result->pluck('id')->all();
            $fallback = $this->ruleBasedRecommendation($limit - $result->count())
                ->filter(fn($p) => !in_array($p->id, $existing));
            $result = $result->merge($fallback)->values();
        }

        return $result;
    }

    /**
     * Bangun user profile vector dari riwayat pembelian.
     * Weighted average berdasarkan quantity.
     */
    private function buildUserVector(Collection $history): array
    {
        $totalQty = $history->sum('quantity') ?: 1;

        return [
            'volume_l' => $history->sum(fn($i) => ($i->product->volume_l ?? 0) * $i->quantity) / $totalQty,
            'price'    => $history->sum(fn($i) => ($i->product->price    ?? 0) * $i->quantity) / $totalQty,
        ];
    }

    /**
     * Normalisasi user vector ke range [0, 1] menggunakan max global.
     */
    private function normalizeUserVector(array $userVector, float $maxPrice, float $maxVolume): array
    {
        return [
            'volume_l' => $maxVolume > 0 ? $userVector['volume_l'] / $maxVolume : 0,
            'price'    => $maxPrice  > 0 ? $userVector['price']    / $maxPrice  : 0,
        ];
    }

    /**
     * Normalisasi vektor produk ke range [0, 1].
     */
    private function normalizeVector(Product $p, float $maxPrice, float $maxVolume): array
    {
        return [
            'volume_l' => $maxVolume > 0 ? $p->volume_l / $maxVolume : 0,
            'price'    => $maxPrice  > 0 ? $p->price    / $maxPrice  : 0,
        ];
    }

    /**
     * Cosine similarity antara dua vektor asosiatif yang sudah dinormalisasi.
     * Return: nilai antara 0..1
     */
    private function cosineSimilarity(array $a, array $b): float
    {
        $dot = $normA = $normB = 0;

        foreach (array_keys($b) as $k) {
            $av     = $a[$k] ?? 0;
            $bv     = $b[$k] ?? 0;
            $dot   += $av * $bv;
            $normA += $av * $av;
            $normB += $bv * $bv;
        }

        $denom = sqrt($normA) * sqrt($normB);
        return $denom > 0 ? $dot / $denom : 0;
    }

    private function cbfReason(float $similarity, float $boost): string
    {
        if ($similarity > 0.9) return 'Sangat sesuai preferensi Anda';
        if ($similarity > 0.7) return 'Sesuai preferensi Anda';
        if ($boost > 0.08)     return 'Populer & relevan';
        return 'Mungkin Anda suka';
    }

    // ──────────────────────────────────────────────────────────────
    // HELPER
    // ──────────────────────────────────────────────────────────────

    /**
     * Ambil riwayat order_items user (order yang sudah/sedang diproses).
     * Eager-load product agar tidak N+1.
     */
    private function getUserHistory(string $userId): Collection
    {
        return \App\Models\OrderItem::with('product')
            ->whereHas('order', fn($q) =>
                $q->where('user_id', $userId)
                  ->whereIn('status', ['delivered', 'completed', 'confirmed', 'on_delivery'])
            )
            ->get();
    }
}