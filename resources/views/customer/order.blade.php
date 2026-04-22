<x-app-layout>
<div class="ef-orders">

    @php
        $activeTab = request('tab', 'riwayat');

        $tabs = [
            'riwayat' => ['label' => 'Riwayat', 'icon' => 'history'],
            'dalam' => ['label' => 'Dalam Pengantaran', 'icon' => 'truck'],
            'draf' => ['label' => 'Draf', 'icon' => 'draft'],
            'batal' => ['label' => 'Batal', 'icon' => 'cancel'],
        ];

        $orders = [
            (object) [
                'id' => 124,
                'toko' => 'Gogalon Maospat',
                'status' => 'dalam',
                'statusText' => 'Dalam Pengantaran',
                'statusColor' => 'orange',
                'date' => '30 Okt, 18:41',
                'barang' => '2 Galon Aqua',
                'price' => 'Rp28.000',
            ],
            (object) [
                'id' => 123,
                'toko' => 'Depot Air Salwa',
                'status' => 'riwayat',
                'statusText' => 'Selesai',
                'statusColor' => 'green',
                'date' => '29 Okt, 22:58',
                'barang' => '1 Galon Aqua',
                'price' => 'Rp14.000',
            ],
            (object) [
                'id' => 122,
                'toko' => 'Depot Air Mas Jaya',
                'status' => 'batal',
                'statusText' => 'Dibatalkan',
                'statusColor' => 'gray',
                'date' => '28 Okt, 21:15',
                'barang' => '2 Galon Club',
                'price' => 'Rp28.000',
            ],
            (object) [
                'id' => 121,
                'toko' => 'Gogalon Express',
                'status' => 'draf',
                'statusText' => 'Draf',
                'statusColor' => 'blue',
                'date' => '—',
                'barang' => '1 Galon Aqua',
                'price' => 'Rp14.000',
            ],
        ];

        $countByTab = [];
        foreach ($orders as $o) {
            $countByTab[$o->status] = ($countByTab[$o->status] ?? 0) + 1;
        }
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
                       role="tab" aria-selected="{{ $activeTab === $key ? 'true' : 'false' }}">

                        {{-- Icon --}}
                        @if ($tab['icon'] === 'history')
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        @elseif ($tab['icon'] === 'truck')
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                        @elseif ($tab['icon'] === 'draft')
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="13" x2="15" y2="13"/></svg>
                        @else
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                        @endif

                        <div class="bg-white rounded-xl shadow-sm p-3 flex gap-3">

                            {{-- ICON GALON --}}
                            <div class="w-16 h-16 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                                <img src="{{ asset('assets/icons/galon.png') }}" alt="galon" class="w-10 h-10">
                            </div>

                            {{-- CONTENT --}}
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <p class="font-semibold text-sm">{{ $order->toko }}</p>

                                    <span class="text-xs px-2 py-1 rounded-full
                                                    @if($order->statusColor === 'green') bg-green- 100 text-green-700 @endif
                                                    @if($order->statusColor === 'orange') bg-orange-100 text-orange-700 @endif
                                                    @if($order->statusColor === 'gray') bg-gray-200 text-gray-600 @endif
                                                ">
                                        {{ $order->statusText }}
                                    </span>
                                </div>

                                <p class="text-xs text-gray-500 mt-1">{{ $order->date }}</p>
                                <p class="text-sm mt-1">{{ $order->barang }}</p>

                                <div class="flex justify-between items-center mt-2">
                                    <p class="font-semibold text-sm">{{ $order->price }}</p>

                                    @if ($order->status === 'riwayat')
                                        <button class="text-green-600 text-sm font-semibold">
                                            Pesan lagi
                                        </button>
                                    @elseif ($order->status === 'dalam')
                                        <button class="text-orange-600 text-sm font-semibold">
                                            Lacak
                                        </button>
                                    @elseif ($order->status === 'draf')
                                        <button class="text-blue-600 text-sm font-semibold">
                                            Lanjutkan
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                    @endif
                @empty
                    <p class="text-center text-gray-500 mt-10">
                        Tidak ada pesanan
                    </p>
                @endforelse

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
            @if ($order->status === $activeTab)
                @php $shown++; @endphp

                <article class="ef-order-card" data-reveal data-delay="{{ ($shown - 1) * 70 }}">

                    {{-- Left: Icon --}}
                    <div class="ef-order-card__icon
                        @if($order->statusColor === 'green')  ef-order-card__icon--green  @endif
                        @if($order->statusColor === 'orange') ef-order-card__icon--orange @endif
                        @if($order->statusColor === 'blue')   ef-order-card__icon--blue   @endif
                        @if($order->statusColor === 'gray')   ef-order-card__icon--gray   @endif
                    ">
                        @if($order->statusColor === 'orange')
                            {{-- Truck icon for delivery --}}
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                        @elseif($order->statusColor === 'green')
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        @elseif($order->statusColor === 'blue')
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        @else
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                        @endif
                    </div>

                    {{-- Middle: Info --}}
                    <div class="ef-order-card__body">
                        <div class="ef-order-card__top">
                            <div>
                                <p class="ef-order-card__store">{{ $order->toko }}</p>
                                <p class="ef-order-card__id">#{{ $order->id }} · {{ $order->date }}</p>
                            </div>
                            <span class="ef-order-card__badge
                                @if($order->statusColor === 'green')  ef-order-card__badge--green  @endif
                                @if($order->statusColor === 'orange') ef-order-card__badge--orange @endif
                                @if($order->statusColor === 'blue')   ef-order-card__badge--blue   @endif
                                @if($order->statusColor === 'gray')   ef-order-card__badge--gray   @endif
                            ">
                                @if($order->statusColor === 'orange')
                                    <span class="ef-order-card__badge-dot"></span>
                                @endif
                                {{ $order->statusText }}
                            </span>
                        </div>

                        <div class="ef-order-card__divider"></div>

                        <div class="ef-order-card__bottom">
                            <div class="ef-order-card__item">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                {{ $order->barang }}
                            </div>
                            <div class="ef-order-card__right">
                                <span class="ef-order-card__price">{{ $order->price }}</span>

                                @if ($order->status === 'riwayat')
                                    <button class="ef-order-card__btn ef-order-card__btn--green">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/></svg>
                                        Pesan Lagi
                                    </button>
                                @elseif ($order->status === 'dalam')
                                    <button class="ef-order-card__btn ef-order-card__btn--orange">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                        Lacak
                                    </button>
                                @elseif ($order->status === 'draf')
                                    <button class="ef-order-card__btn ef-order-card__btn--blue">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                        Lanjutkan
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </article>
            @endif
        @endforeach

        @if ($shown === 0)
            <div class="ef-orders__empty" data-reveal>
                <div class="ef-orders__empty-icon">
                    @if ($activeTab === 'dalam')
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="3" width="15" height="13"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                    @elseif ($activeTab === 'batal')
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    @elseif ($activeTab === 'draf')
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    @else
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
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
    }, { threshold: 0.1 });
    els.forEach(el => ro.observe(el));
});
</script>
</x-app-layout>