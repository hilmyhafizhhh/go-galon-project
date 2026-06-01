<x-app-layout>
    <div class="ef-orders">
        @php
            $activeTab = $activeTab ?? request('tab', 'pending');

            $tabs = [
                'pending'   => ['label' => 'Menunggu', 'icon' => 'draft'],
                'shipping'  => ['label' => 'Dikirim', 'icon' => 'truck'],
                'completed' => ['label' => 'Selesai', 'icon' => 'history'],
                'cancelled' => ['label' => 'Batal', 'icon' => 'cancel'],
            ];

            $statusDisplay = [
                'pending'     => ['text' => 'Menunggu Konfirmasi', 'color' => 'yellow'],
                'confirmed'   => ['text' => 'Dikonfirmasi', 'color' => 'blue'],
                'on_delivery' => ['text' => 'Dalam Pengantaran', 'color' => 'orange'],
                'completed'   => ['text' => 'Selesai', 'color' => 'green'],
                'cancelled'   => ['text' => 'Dibatalkan', 'color' => 'red'],
            ];
        @endphp

        {{-- ── STICKY HEADER ── --}}
        <div class="ef-orders__header">
            <div class="ef-orders__header-inner">
                <div class="ef-orders__title-row">
                    <h1 class="ef-orders__title">Aktivitas</h1>
                    <span class="ef-orders__subtitle">Riwayat & status pesanan Anda</span>
                </div>

                {{-- Tab Filter --}}
                <div class="ef-tabs" role="tablist">
                    @foreach ($tabs as $key => $tab)
                        <a href="?tab={{ $key }}"
                            class="ef-tab {{ $activeTab === $key ? 'ef-tab--active' : '' }}"
                            role="tab"
                            aria-selected="{{ $activeTab === $key ? 'true' : 'false' }}">

                            @if ($tab['icon'] === 'history')
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                </svg>
                            @elseif ($tab['icon'] === 'truck')
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                    <rect x="1" y="3" width="15" height="13"/>
                                    <path d="M16 8h4l3 3v5h-7V8z"/>
                                    <circle cx="5.5" cy="18.5" r="2.5"/>
                                    <circle cx="18.5" cy="18.5" r="2.5"/>
                                </svg>
                            @elseif ($tab['icon'] === 'draft')
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                    <line x1="9" y1="13" x2="15" y2="13"/>
                                </svg>
                            @else
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="15" y1="9" x2="9" y2="15"/>
                                    <line x1="9" y1="9" x2="15" y2="15"/>
                                </svg>
                            @endif

                            {{ $tab['label'] }}

                            @if (!empty($countByTab[$key]))
                                <span class="ef-tab__count {{ $activeTab === $key ? 'ef-tab__count--active' : '' }}">
                                    {{ $countByTab[$key] }}
                                </span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ── ORDER LIST ── --}}
        <div class="ef-orders__list">
            @php $shown = 0; @endphp

            @foreach ($orders as $order)
                @php
                    $shown++;
                    $display = $statusDisplay[$order->status] ?? ['text' => $order->status, 'color' => 'gray'];
                    $itemSummary = $order->items->map(
                        fn($i) => $i->quantity . ' ' . (optional($i->product)->name ?? 'Produk Dihapus')
                    )->join(', ');
                @endphp

                <article class="ef-order-card" data-reveal data-delay="{{ $loop->index * 70 }}">

                    <div class="ef-order-card__icon ef-order-card__icon--{{ $display['color'] }}">
                        @if($order->status === 'pending')
                            ⏳
                        @elseif($order->status === 'confirmed')
                            ✅
                        @elseif($order->status === 'on_delivery')
                            🚴
                        @elseif($order->status === 'completed')
                            🎉
                        @else
                            ❌
                        @endif
                    </div>

                    <div class="ef-order-card__body">
                        <div class="ef-order-card__top">
                            <div>
                                <p class="ef-order-card__store">{{ $order->address->label ?? 'Tanpa Alamat' }}</p>
                                <p class="ef-order-card__id">
                                    #{{ $order->order_code ?? substr($order->id, 0, 8) }} ·
                                    {{ $order->created_at->format('d M, H:i') }}
                                </p>

                                {{-- Nomor Antrean --}}
                                @if($order->queue_number)
                                    <p class="ef-order-card__queue">
                                        <span style="background:#1e293b;color:#fff;font-size:.65rem;font-weight:700;padding:2px 8px;border-radius:999px;">
                                            Antrean #{{ $order->queue_number }}
                                        </span>
                                    </p>
                                @endif
                            </div>
                            <span class="ef-order-card__badge ef-order-card__badge--{{ $display['color'] }}">
                                @if ($display['color'] === 'orange')
                                    <span class="ef-order-card__badge-dot"></span>
                                @endif
                                {{ $display['text'] }}
                            </span>
                        </div>

                        {{-- Info tambahan saat dikonfirmasi --}}
                        @if($order->status === 'confirmed')
                            <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:8px 12px;margin:8px 0;font-size:.75rem;color:#1d4ed8;">
                                ✅ Pesanan kamu sudah dikonfirmasi dan akan segera disiapkan oleh kurir.
                            </div>
                        @endif

                        {{-- Info saat on_delivery --}}
                        @if($order->status === 'on_delivery')
                            <div style="background:#fff7ed;border:1px solid #fed7aa;border-radius:8px;padding:8px 12px;margin:8px 0;font-size:.75rem;color:#c2410c;">
                                🚴 Pesanan kamu sedang dalam perjalanan menuju lokasi kamu.
                            </div>
                        @endif

                        <div class="ef-order-card__divider"></div>

                        <div class="ef-order-card__bottom">
                            <div class="ef-order-card__item">{{ $itemSummary }}</div>
                            <div class="ef-order-card__right">
                                <span class="ef-order-card__price">
                                    Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                                </span>
                                @if ($order->status === 'completed')
                                    <button class="ef-order-card__btn ef-order-card__btn--green">Pesan Lagi</button>
                                @elseif ($order->status === 'on_delivery')
                                    <button class="ef-order-card__btn ef-order-card__btn--orange">Lacak</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach

            @if ($shown === 0)
                <div class="ef-orders__empty" data-reveal>
                    <div class="ef-orders__empty-icon">
                        @if ($activeTab === 'shipping')
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect x="1" y="3" width="15" height="13"/>
                                <path d="M16 8h4l3 3v5h-7V8z"/>
                                <circle cx="5.5" cy="18.5" r="2.5"/>
                                <circle cx="18.5" cy="18.5" r="2.5"/>
                            </svg>
                        @elseif ($activeTab === 'cancelled')
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="15" y1="9" x2="9" y2="15"/>
                                <line x1="9" y1="9" x2="15" y2="15"/>
                            </svg>
                        @elseif ($activeTab === 'pending')
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                        @else
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                        @endif
                    </div>
                    <p class="ef-orders__empty-title">Belum ada pesanan</p>
                    <p class="ef-orders__empty-sub">Pesanan di kategori ini akan muncul di sini.</p>
                    <a href="{{ route('customer.home') }}" class="ef-orders__empty-btn">Belanja Sekarang</a>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const els = document.querySelectorAll('[data-reveal]');
            const ro = new IntersectionObserver((entries) => {
                entries.forEach(e => {
                    if (!e.isIntersecting) return;
                    const delay = parseInt(e.target.dataset.delay || 0);
                    setTimeout(() => e.target.classList.add('ef-revealed'), delay);
                    ro.unobserve(e.target);
                });
            }, { threshold: 0.1 });
            els.forEach(el => ro.observe(el));

            // Auto refresh setiap 10 detik untuk update status real-time
            setInterval(() => {
                const currentTab = new URLSearchParams(window.location.search).get('tab') || 'pending';
                fetch(`/customer/order?tab=${currentTab}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(r => r.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newList = doc.querySelector('.ef-orders__list');
                    const currentList = document.querySelector('.ef-orders__list');
                    if (newList && currentList) {
                        currentList.innerHTML = newList.innerHTML;
                    }
                });
            }, 10000); // refresh setiap 10 detik
        });
    </script>
</x-app-layout>