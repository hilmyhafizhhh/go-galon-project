<x-app-layout>
    <div class="ef-orders">
        @php
            $activeTab = $activeTab ?? request('tab', 'pending');

            $tabs = [
                'pending' => ['label' => 'Menunggu', 'icon' => 'draft'],
                'shipping' => ['label' => 'Dikirim', 'icon' => 'truck'],
                'completed' => ['label' => 'Selesai', 'icon' => 'history'],
                'cancelled' => ['label' => 'Batal', 'icon' => 'cancel'],
            ];

            $statusDisplay = [
                'pending' => ['text' => 'Menunggu Konfirmasi', 'color' => 'yellow'],
                'confirmed' => ['text' => 'Dikonfirmasi', 'color' => 'blue'],
                'on_delivery' => ['text' => 'Dalam Pengantaran', 'color' => 'orange'],
                'completed' => ['text' => 'Selesai', 'color' => 'green'],
                'cancelled' => ['text' => 'Dibatalkan', 'color' => 'red'],
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

                            @if ($tab['icon'] === 'history')
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.2">
                                    <circle cx="12" cy="12" r="10" />
                                    <polyline points="12 6 12 12 16 14" />
                                </svg>
                            @elseif ($tab['icon'] === 'truck')
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.2">
                                    <rect x="1" y="3" width="15" height="13" />
                                    <path d="M16 8h4l3 3v5h-7V8z" />
                                    <circle cx="5.5" cy="18.5" r="2.5" />
                                    <circle cx="18.5" cy="18.5" r="2.5" />
                                </svg>
                            @elseif ($tab['icon'] === 'draft')
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.2">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                    <line x1="9" y1="13" x2="15" y2="13" />
                                </svg>
                            @else
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.2">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="15" y1="9" x2="9" y2="15" />
                                    <line x1="9" y1="9" x2="15" y2="15" />
                                </svg>
                            @endif

                            {{ $tab['label'] }}

                            {{-- Badge count dengan data attribute untuk update JS --}}
                            <span class="ef-tab__count {{ $activeTab === $key ? 'ef-tab__count--active' : '' }}"
                                data-tab-count="{{ $key }}"
                                style="{{ empty($countByTab[$key]) ? 'display:none' : '' }}">
                                {{ $countByTab[$key] ?? 0 }}
                            </span>
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
                    $itemSummary = $order->items
                        ->map(fn($i) => $i->quantity . ' ' . (optional($i->product)->name ?? 'Produk Dihapus'))
                        ->join(', ');
                @endphp

                {{-- Tambah data-order-id untuk update JS --}}
                <article class="ef-order-card" data-order-id="{{ $order->id }}"
                    data-current-status="{{ $order->status }}" data-reveal data-delay="{{ $loop->index * 70 }}">

                    {{-- Icon dengan data attribute --}}
                    <div class="ef-order-card__icon ef-order-card__icon--{{ $display['color'] }}"
                        data-order-icon="{{ $order->id }}">
                        @if ($order->status === 'pending')
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

                                {{-- Nomor Antrean dengan data attribute --}}
                                <p class="ef-order-card__queue" data-order-queue="{{ $order->id }}"
                                    style="{{ $order->queue_number ? '' : 'display:none' }}">
                                    <span
                                        style="background:#1e293b;color:#fff;font-size:.65rem;font-weight:700;padding:2px 8px;border-radius:999px;">
                                        Antrean #{{ $order->queue_number }}
                                    </span>
                                </p>
                            </div>

                            {{-- Badge status dengan data attribute --}}
                            <span class="ef-order-card__badge ef-order-card__badge--{{ $display['color'] }}"
                                data-order-badge="{{ $order->id }}">
                                @if ($display['color'] === 'orange')
                                    <span class="ef-order-card__badge-dot"></span>
                                @endif
                                {{ $display['text'] }}
                            </span>
                        </div>

                        {{-- Info banner dengan data attribute --}}
                        <div data-order-info="{{ $order->id }}">
                            @if ($order->status === 'confirmed')
                                <div
                                    style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:8px 12px;margin:8px 0;font-size:.75rem;color:#1d4ed8;">
                                    ✅ Pesanan kamu sudah dikonfirmasi dan akan segera disiapkan oleh kurir.
                                </div>
                            @elseif($order->status === 'on_delivery')
                                <div
                                    style="background:#fff7ed;border:1px solid #fed7aa;border-radius:8px;padding:8px 12px;margin:8px 0;font-size:.75rem;color:#c2410c;">
                                    🚴 Pesanan kamu sedang dalam perjalanan menuju lokasi kamu.
                                </div>
                            @endif
                        </div>

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
                                    {{-- ✅ Ganti jadi link ke halaman tracking --}}
                                    <a href="{{ route('tracking.show', $order->order_code) }}"
                                        class="ef-order-card__btn ef-order-card__btn--orange"
                                        style="text-decoration:none;display:inline-flex;align-items:center;gap:.3rem;">
                                        📍 Lacak
                                    </a>
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
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.5">
                                <rect x="1" y="3" width="15" height="13" />
                                <path d="M16 8h4l3 3v5h-7V8z" />
                                <circle cx="5.5" cy="18.5" r="2.5" />
                                <circle cx="18.5" cy="18.5" r="2.5" />
                            </svg>
                        @elseif ($activeTab === 'cancelled')
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="15" y1="9" x2="9" y2="15" />
                                <line x1="9" y1="9" x2="15" y2="15" />
                            </svg>
                        @elseif ($activeTab === 'pending')
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // ── Scroll Reveal ──
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

            // ── Config ──
            const STATUS_DISPLAY = {
                'pending': {
                    text: 'Menunggu Konfirmasi',
                    color: 'yellow',
                    icon: '⏳'
                },
                'confirmed': {
                    text: 'Dikonfirmasi',
                    color: 'blue',
                    icon: '✅'
                },
                'on_delivery': {
                    text: 'Dalam Pengantaran',
                    color: 'orange',
                    icon: '🚴'
                },
                'completed': {
                    text: 'Selesai',
                    color: 'green',
                    icon: '🎉'
                },
                'cancelled': {
                    text: 'Dibatalkan',
                    color: 'red',
                    icon: '❌'
                },
            };

            const INFO_TEXT = {
                'confirmed': '✅ Pesanan kamu sudah dikonfirmasi dan akan segera disiapkan oleh kurir.',
                'on_delivery': '🚴 Pesanan kamu sedang dalam perjalanan menuju lokasi kamu.',
            };

            const INFO_STYLE = {
                'confirmed': 'background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:8px 12px;margin:8px 0;font-size:.75rem;color:#1d4ed8;',
                'on_delivery': 'background:#fff7ed;border:1px solid #fed7aa;border-radius:8px;padding:8px 12px;margin:8px 0;font-size:.75rem;color:#c2410c;',
            };

            // Status → tab mapping
            const STATUS_TO_TAB = {
                'pending': 'pending',
                'confirmed': 'pending',
                'on_delivery': 'shipping',
                'completed': 'completed',
                'cancelled': 'cancelled',
            };

            // ── State ──
            let currentTab = new URLSearchParams(window.location.search).get('tab') || 'pending';

            // Cache semua order dari SEMUA tab di memori
            // key: order.id, value: order object
            let allOrdersCache = {};

            // ── Helpers ──
            function renderCard(order) {
                const display = STATUS_DISPLAY[order.status] ?? {
                    text: order.status,
                    color: 'gray',
                    icon: '?'
                };
                const itemSummary = (order.items || []).map(i => `${i.quantity} ${i.name}`).join(', ');
                const infoBanner = INFO_TEXT[order.status] ?
                    `<div style="${INFO_STYLE[order.status]}">${INFO_TEXT[order.status]}</div>` :
                    '';
                const queueBadge = order.queue_number ?
                    `<p class="ef-order-card__queue" data-order-queue="${order.id}">
                <span style="background:#1e293b;color:#fff;font-size:.65rem;font-weight:700;padding:2px 8px;border-radius:999px;">
                    Antrean #${order.queue_number}
                </span></p>` :
                    `<p class="ef-order-card__queue" data-order-queue="${order.id}" style="display:none"></p>`;

                const dotBadge = display.color === 'orange' ?
                    `<span class="ef-order-card__badge-dot"></span>${display.text}` :
                    display.text;

                let actionBtn = '';
                if (order.status === 'completed') {
                    actionBtn = `<button class="ef-order-card__btn ef-order-card__btn--green">Pesan Lagi</button>`;
                } else if (order.status === 'on_delivery') {
                    actionBtn =
                        `<a href="/tracking/${order.order_code}" class="ef-order-card__btn ef-order-card__btn--orange" style="text-decoration:none;display:inline-flex;align-items:center;gap:.3rem;">📍 Lacak</a>`;
                }

                return `
            <article class="ef-order-card ef-revealed" data-order-id="${order.id}" data-current-status="${order.status}">
                <div class="ef-order-card__icon ef-order-card__icon--${display.color}" data-order-icon="${order.id}">
                    ${display.icon}
                </div>
                <div class="ef-order-card__body">
                    <div class="ef-order-card__top">
                        <div>
                            <p class="ef-order-card__store">${order.address_label}</p>
                            <p class="ef-order-card__id">#${order.order_code} · ${order.created_at}</p>
                            ${queueBadge}
                        </div>
                        <span class="ef-order-card__badge ef-order-card__badge--${display.color}" data-order-badge="${order.id}">
                            ${dotBadge}
                        </span>
                    </div>
                    <div data-order-info="${order.id}">${infoBanner}</div>
                    <div class="ef-order-card__divider"></div>
                    <div class="ef-order-card__bottom">
                        <div class="ef-order-card__item">${itemSummary}</div>
                        <div class="ef-order-card__right">
                            <span class="ef-order-card__price">Rp${parseInt(order.total_amount).toLocaleString('id-ID')}</span>
                            ${actionBtn}
                        </div>
                    </div>
                </div>
            </article>`;
            }

            function renderEmpty(tab) {
                const icons = {
                    shipping: `<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="3" width="15" height="13"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>`,
                    cancelled: `<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>`,
                    pending: `<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>`,
                    completed: `<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>`,
                };
                return `
            <div class="ef-orders__empty" data-reveal>
                <div class="ef-orders__empty-icon">${icons[tab] || icons.completed}</div>
                <p class="ef-orders__empty-title">Belum ada pesanan</p>
                <p class="ef-orders__empty-sub">Pesanan di kategori ini akan muncul di sini.</p>
                <a href="/customer/home" class="ef-orders__empty-btn">Belanja Sekarang</a>
            </div>`;
            }

            function updateTabBadges(countByTab) {
                Object.keys(countByTab).forEach(tab => {
                    const badge = document.querySelector(`[data-tab-count="${tab}"]`);
                    if (!badge) return;
                    const count = countByTab[tab];
                    badge.innerText = count;
                    badge.style.display = count > 0 ? '' : 'none';
                });
            }

            function switchTabUI(tab) {
                currentTab = tab;
                window.history.pushState({}, '', `?tab=${tab}`);
                document.querySelectorAll('.ef-tab').forEach(el => {
                    const isActive = el.getAttribute('href') === `?tab=${tab}`;
                    el.classList.toggle('ef-tab--active', isActive);
                    el.setAttribute('aria-selected', isActive ? 'true' : 'false');
                    const countBadge = el.querySelector('[data-tab-count]');
                    if (countBadge) countBadge.classList.toggle('ef-tab__count--active', isActive);
                });
            }

            function renderCurrentTab() {
                const list = document.querySelector('.ef-orders__list');
                const ordersForTab = Object.values(allOrdersCache)
                    .filter(o => STATUS_TO_TAB[o.status] === currentTab);

                if (ordersForTab.length === 0) {
                    list.innerHTML = renderEmpty(currentTab);
                } else {
                    list.innerHTML = ordersForTab.map(o => renderCard(o)).join('');
                }
            }

            // ── Polling — fetch semua order sekaligus (tab=all) ──
            // Kalau backend belum support tab=all, ganti dengan tab=${currentTab}
            // tapi pastikan response tetap punya countByTab untuk semua tab
            function poll() {
                fetch(`/customer/order/full-status?tab=all`)
                    .then(r => r.json())
                    .then(data => {
                        updateTabBadges(data.countByTab);

                        let needsTabSwitch = false;
                        let needsRerender = false;

                        // Update cache dan deteksi perubahan
                        data.orders.forEach(order => {
                            const cached = allOrdersCache[order.id];
                            if (!cached) {
                                // Order baru masuk cache
                                allOrdersCache[order.id] = order;
                                if (STATUS_TO_TAB[order.status] === currentTab) needsRerender = true;
                            } else if (cached.status !== order.status) {
                                // Status berubah — update cache DULU
                                allOrdersCache[order.id] = order;

                                const wasInCurrentTab = STATUS_TO_TAB[cached.status] === currentTab;
                                const nowInCurrentTab = STATUS_TO_TAB[order.status] === currentTab;

                                if (wasInCurrentTab && !nowInCurrentTab) {
                                    // Order pindah KELUAR dari tab ini
                                    needsRerender = true;
                                    // Kalau tab ini bakal kosong, perlu switch tab
                                    const remaining = Object.values(allOrdersCache)
                                        .filter(o => STATUS_TO_TAB[o.status] === currentTab);
                                    if (remaining.length === 0) needsTabSwitch = true;
                                } else if (!wasInCurrentTab && nowInCurrentTab) {
                                    // Order baru masuk ke tab ini
                                    needsRerender = true;
                                } else if (wasInCurrentTab && nowInCurrentTab) {
                                    // Status berubah tapi masih di tab yang sama (misalnya pending→confirmed)
                                    needsRerender = true;
                                }
                            } else {
                                // Update data lain (queue_number, dll) tanpa ubah status
                                if (cached.queue_number !== order.queue_number) {
                                    allOrdersCache[order.id] = order;
                                    needsRerender = true;
                                }
                            }
                        });

                        if (needsTabSwitch) {
                            // Cari tab yang paling relevan (ada isinya)
                            const tabPriority = {
                                'pending': ['shipping', 'completed', 'cancelled'],
                                'shipping': ['completed', 'pending', 'cancelled'],
                                'completed': ['pending', 'shipping', 'cancelled'],
                                'cancelled': ['pending', 'shipping', 'completed'],
                            };
                            const candidates = tabPriority[currentTab] || ['pending'];
                            const nextTab = candidates.find(t => (data.countByTab[t] ?? 0) > 0) || candidates[
                            0];
                            switchTabUI(nextTab); // switch tab dulu (instant)
                            // renderCurrentTab() akan jalan di bawah karena needsRerender = true
                        }

                        if (needsRerender) {
                            renderCurrentTab(); // render dari cache, TANPA fetch lagi
                        }
                    })
                    .catch(() => {});
            }

            // Mulai polling
            setInterval(poll, 5000);
            // Langsung poll sekali saat load untuk isi cache awal
            poll();
        });
    </script>
</x-app-layout>
