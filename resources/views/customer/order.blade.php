<x-app-layout>
    <div class="ef-orders">
        @php
            $activeTab = $activeTab ?? request('tab', 'draf');

            $tabs = [
                'riwayat' => ['label' => 'Riwayat', 'icon' => 'history'],
                'dalam' => ['label' => 'Dalam Pengantaran', 'icon' => 'truck'],
                'draf' => ['label' => 'Draf', 'icon' => 'draft'],
                'batal' => ['label' => 'Batal', 'icon' => 'cancel'],
            ];

            // Map status DB → warna & teks tampilan
            $statusDisplay = [
                'pending' => ['text' => 'Dalam Proses', 'color' => 'blue'], // ← tambah ini
                'draft' => ['text' => 'Draf', 'color' => 'blue'],
                'confirmed' => ['text' => 'Dikonfirmasi', 'color' => 'blue'],
                'processing' => ['text' => 'Diproses', 'color' => 'orange'],
                'shipping' => ['text' => 'Dalam Pengantaran', 'color' => 'orange'],
                'delivered' => ['text' => 'Terkirim', 'color' => 'green'],
                'completed' => ['text' => 'Selesai', 'color' => 'green'],
                'cancelled' => ['text' => 'Dibatalkan', 'color' => 'gray'],
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
                            class="ef-tab {{ $activeTab === $key ? 'ef-tab--active' : '' }}" role="tab"
                            aria-selected="{{ $activeTab === $key ? 'true' : 'false' }}">

                            {{-- Icon --}}
                            @if ($tab['icon'] === 'history')
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <polyline points="12 6 12 12 16 14" />
                                </svg>
                            @elseif ($tab['icon'] === 'truck')
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect x="1" y="3" width="15" height="13" />
                                    <path d="M16 8h4l3 3v5h-7V8z" />
                                    <circle cx="5.5" cy="18.5" r="2.5" />
                                    <circle cx="18.5" cy="18.5" r="2.5" />
                                </svg>
                            @elseif ($tab['icon'] === 'draft')
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                    <line x1="9" y1="13" x2="15" y2="13" />
                                </svg>
                            @else
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="15" y1="9" x2="9" y2="15" />
                                    <line x1="9" y1="9" x2="15" y2="15" />
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
                    // $itemSummary = $order->items->map(fn($i) => $i->quantity . ' ' . $i->product->name)->join(', ');
                    $itemSummary = $order->items->map(
                        fn($i) => $i->quantity . ' ' . (optional($i->product)->name ?? 'Produk Dihapus')
                    )->join(', '); //diperbarui
                @endphp

                <article class="ef-order-card" data-reveal data-delay="{{ $loop->index * 70 }}">

                    {{-- Icon & badge pakai $display['color'] --}}
                    <div class="ef-order-card__icon ef-order-card__icon--{{ $display['color'] }}">
                        ...
                    </div>

                    <div class="ef-order-card__body">
                        <div class="ef-order-card__top">
                            <div>
                                <p class="ef-order-card__store">{{ $order->address->label ?? 'Tanpa Alamat' }}</p>
                                <p class="ef-order-card__id">
                                    #{{ $order->order_code ?? substr($order->id, 0, 8) }} ·
                                    {{ $order->created_at->format('d M, H:i') }}
                                </p>
                            </div>
                            <span class="ef-order-card__badge ef-order-card__badge--{{ $display['color'] }}">
                                @if ($display['color'] === 'orange')
                                    <span class="ef-order-card__badge-dot"></span>
                                @endif
                                {{ $display['text'] }}
                            </span>
                        </div>

                        <div class="ef-order-card__divider"></div>

                        <div class="ef-order-card__bottom">
                            <div class="ef-order-card__item">
                                {{ $itemSummary }}
                            </div>
                            <div class="ef-order-card__right">
                                <span class="ef-order-card__price">
                                    Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                                </span>

                                @if ($order->status === 'completed' || $order->status === 'delivered')
                                    <button class="ef-order-card__btn ef-order-card__btn--green">Pesan Lagi</button>
                                @elseif (in_array($order->status, ['processing', 'shipping']))
                                    <button class="ef-order-card__btn ef-order-card__btn--orange">Lacak</button>
                                @elseif ($order->status === 'draft')
                                    <a href="{{ route('customer.checkout.index') }}"
                                        class="ef-order-card__btn ef-order-card__btn--blue">Lanjutkan</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
            @if ($shown === 0)
                <div class="ef-orders__empty" data-reveal>
                    <div class="ef-orders__empty-icon">
                        @if ($activeTab === 'dalam')
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.5">
                                <rect x="1" y="3" width="15" height="13" />
                                <path d="M16 8h4l3 3v5h-7V8z" />
                                <circle cx="5.5" cy="18.5" r="2.5" />
                                <circle cx="18.5" cy="18.5" r="2.5" />
                            </svg>
                        @elseif ($activeTab === 'batal')
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="15" y1="9" x2="9" y2="15" />
                                <line x1="9" y1="9" x2="15" y2="15" />
                            </svg>
                        @elseif ($activeTab === 'draf')
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.5">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                            </svg>
                        @else
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
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

    {{-- Scroll Reveal --}}
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
            }, {
                threshold: 0.1
            });
            els.forEach(el => ro.observe(el));
        });
    </script>
</x-app-layout>
