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

                <article class="ef-order-card ef-revealed" data-order-id="{{ $order->id }}"
                    data-current-status="{{ $order->status }}" data-reveal data-delay="{{ $loop->index * 70 }}">

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
                                <p class="ef-order-card__queue" data-order-queue="{{ $order->id }}"
                                    style="{{ $order->queue_number ? '' : 'display:none' }}">
                                    <span
                                        style="background:#1e293b;color:#fff;font-size:.65rem;font-weight:700;padding:2px 8px;border-radius:999px;">
                                        Antrean #{{ $order->queue_number }}
                                    </span>
                                </p>
                            </div>

                            <span class="ef-order-card__badge ef-order-card__badge--{{ $display['color'] }}"
                                data-order-badge="{{ $order->id }}">
                                @if ($display['color'] === 'orange')
                                    <span class="ef-order-card__badge-dot"></span>
                                @endif
                                {{ $display['text'] }}
                            </span>
                        </div>

                        {{-- Info banner --}}
                        <div data-order-info="{{ $order->id }}">
                            @if ($order->status === 'confirmed')
                                <div
                                    style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:8px 12px;margin:8px 0;font-size:.75rem;color:#1d4ed8;">
                                    ✅ Pesanan dikonfirmasi dan sedang disiapkan.
                                    @if ($order->task?->courier)
                                        <span class="courier-name"
                                            style="margin-top:4px;display:block;font-weight:600;">
                                            🛵 Kurir: {{ $order->task->courier->name }}
                                        </span>
                                    @endif
                                </div>
                            @elseif($order->status === 'on_delivery')
                                <div
                                    style="background:#fff7ed;border:1px solid #fed7aa;border-radius:8px;padding:8px 12px;margin:8px 0;font-size:.75rem;color:#c2410c;">
                                    🚴 Pesanan sedang dalam perjalanan menuju lokasi kamu.
                                    @if ($order->task?->courier)
                                        <span class="courier-name"
                                            style="display:block;margin-top:4px;font-weight:600;">
                                            🛵 Kurir: {{ $order->task->courier->name }}
                                        </span>
                                    @endif
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
                                @elseif ($order->status === 'confirmed' && $order->task?->courier)
                                    <a href="{{ route('customer.chat.show', ['receiver' => $order->task->courier->id]) }}?order_id={{ $order->id }}"
                                        class="ef-order-card__btn" id="chat-btn-order-{{ $order->id }}"
                                        data-courier-id="{{ $order->task->courier->id }}"
                                        style="text-decoration:none;display:inline-flex;align-items:center;gap:.3rem;background:#eff6ff;color:#2563eb;border:1px solid #dbeafe;position:relative;">
                                        <svg width="13" height="13" fill="none" stroke="currentColor"
                                            stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                                        </svg>
                                        Chat Kurir
                                        <span id="chat-badge-order-{{ $order->id }}"
                                            style="display:none;position:absolute;top:-6px;right:-6px;background:#ef4444;color:#fff;font-size:.55rem;font-weight:700;min-width:16px;height:16px;border-radius:999px;align-items:center;justify-content:center;padding:0 3px;border:2px solid #fff;line-height:1;"></span>
                                    </a>
                                @elseif ($order->status === 'on_delivery')
                                    <div style="display:flex;gap:.4rem;align-items:center;"
                                        data-order-actions="{{ $order->id }}">
                                        <a href="{{ route('tracking.show', $order->order_code) }}"
                                            class="ef-order-card__btn ef-order-card__btn--orange"
                                            style="text-decoration:none;display:inline-flex;align-items:center;gap:.3rem;">
                                            📍 Lacak
                                        </a>
                                        @if ($order->task?->courier)
                                            <a href="{{ route('customer.chat.show', ['receiver' => $order->task->courier->id]) }}?order_id={{ $order->id }}"
                                                class="ef-order-card__btn" id="chat-btn-order-{{ $order->id }}"
                                                data-courier-id="{{ $order->task->courier->id }}"
                                                style="text-decoration:none;display:inline-flex;align-items:center;gap:.3rem;background:#eff6ff;color:#2563eb;border:1px solid #dbeafe;position:relative;">
                                                <svg width="13" height="13" fill="none"
                                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                                                </svg>
                                                Chat Kurir
                                                <span id="chat-badge-order-{{ $order->id }}"
                                                    style="display:none;position:absolute;top:-6px;right:-6px;background:#ef4444;color:#fff;font-size:.55rem;font-weight:700;min-width:16px;height:16px;border-radius:999px;align-items:center;justify-content:center;padding:0 3px;border:2px solid #fff;line-height:1;"></span>
                                            </a>
                                        @endif
                                    </div>
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
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.5">
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

    {{-- <script>
        let hiddenAt = null;
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'hidden') {
                hiddenAt = Date.now();
            } else if (document.visibilityState === 'visible') {
                if (hiddenAt && Date.now() - hiddenAt > 3000) location.reload();
            }
        });

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

            const INFO_STYLE = {
                'confirmed': 'background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:8px 12px;margin:8px 0;font-size:.75rem;color:#1d4ed8;',
                'on_delivery': 'background:#fff7ed;border:1px solid #fed7aa;border-radius:8px;padding:8px 12px;margin:8px 0;font-size:.75rem;color:#c2410c;',
            };

            const INFO_ICON = {
                'confirmed': '✅',
                'on_delivery': '🚴'
            };
            const INFO_TEXT = {
                'confirmed': 'Pesanan dikonfirmasi dan sedang disiapkan.',
                'on_delivery': 'Pesanan sedang dalam perjalanan menuju lokasi kamu.',
            };

            // Status → tab
            const STATUS_TO_TAB = {
                'pending': 'pending',
                'confirmed': 'pending',
                'on_delivery': 'shipping',
                'completed': 'completed',
                'cancelled': 'cancelled',
            };

            // ── State ──
            let currentTab = new URLSearchParams(window.location.search).get('tab') || 'pending';
            let allOrdersCache = {}; // id → order object
            const unreadMap = {}; // order_id → unread count

            // ── Helpers ──
            function infoBanner(order) {
                if (!INFO_STYLE[order.status]) return '';
                const courierLine = order.courier_name ?
                    `<span style="display:block;margin-top:4px;font-weight:600;">🛵 Kurir: ${order.courier_name}</span>` :
                    '';
                return `<div style="${INFO_STYLE[order.status]}">${INFO_ICON[order.status]} ${INFO_TEXT[order.status]}${courierLine}</div>`;
            }

            function chatBtn(order) {
                if (!order.courier_id) return '';
                if (order.status !== 'confirmed' && order.status !== 'on_delivery') return '';
                const unread = unreadMap[order.id] || 0;
                const badgeStyle = unread > 0 ?
                    'display:inline-flex;position:absolute;top:-6px;right:-6px;background:#ef4444;color:#fff;font-size:.55rem;font-weight:700;min-width:16px;height:16px;border-radius:999px;align-items:center;justify-content:center;padding:0 3px;border:2px solid #fff;line-height:1;' :
                    'display:none;position:absolute;top:-6px;right:-6px;background:#ef4444;color:#fff;font-size:.55rem;font-weight:700;min-width:16px;height:16px;border-radius:999px;align-items:center;justify-content:center;padding:0 3px;border:2px solid #fff;line-height:1;';
                return `
                <a href="/customer/chat/user/${order.courier_id}?order_id=${order.id}"
                    class="ef-order-card__btn"
                    id="chat-btn-order-${order.id}"
                    data-courier-id="${order.courier_id}"
                    style="text-decoration:none;display:inline-flex;align-items:center;gap:.3rem;background:#eff6ff;color:#2563eb;border:1px solid #dbeafe;position:relative;">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
                    </svg>
                    Chat Kurir
                    <span id="chat-badge-order-${order.id}" style="${badgeStyle}">${unread > 9 ? '9+' : unread}</span>
                </a>`;
            }

            function actionButtons(order) {
                if (order.status === 'completed') {
                    return `<button class="ef-order-card__btn ef-order-card__btn--green">Pesan Lagi</button>`;
                }
                if (order.status === 'confirmed') {
                    return chatBtn(order);
                }
                if (order.status === 'on_delivery') {
                    return `
                    <div style="display:flex;gap:.4rem;align-items:center;">
                        <a href="/tracking/${order.order_code}"
                            class="ef-order-card__btn ef-order-card__btn--orange"
                            style="text-decoration:none;display:inline-flex;align-items:center;gap:.3rem;">
                            📍 Lacak
                        </a>
                        ${chatBtn(order)}
                    </div>`;
                }
                return '';
            }

            function renderCard(order) {
                const display = STATUS_DISPLAY[order.status] ?? {
                    text: order.status,
                    color: 'gray',
                    icon: '?'
                };
                const itemSummary = (order.items || []).map(i => `${i.quantity} ${i.name}`).join(', ');
                const dotBadge = display.color === 'orange' ?
                    `<span class="ef-order-card__badge-dot"></span>${display.text}` :
                    display.text;
                const queueBadge = order.queue_number ?
                    `<p class="ef-order-card__queue" data-order-queue="${order.id}">
                        <span style="background:#1e293b;color:#fff;font-size:.65rem;font-weight:700;padding:2px 8px;border-radius:999px;">
                            Antrean #${order.queue_number}
                        </span>
                   </p>` :
                    `<p class="ef-order-card__queue" data-order-queue="${order.id}" style="display:none"></p>`;

                return `
                <article class="ef-order-card ef-revealed"
                    data-order-id="${order.id}"
                    data-current-status="${order.status}">
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
                        <div data-order-info="${order.id}">${infoBanner(order)}</div>
                        <div class="ef-order-card__divider"></div>
                        <div class="ef-order-card__bottom">
                            <div class="ef-order-card__item">${itemSummary}</div>
                            <div class="ef-order-card__right">
                                <span class="ef-order-card__price">Rp${parseInt(order.total_amount).toLocaleString('id-ID')}</span>
                                ${actionButtons(order)}
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
                <div class="ef-orders__empty">
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
                    const cb = el.querySelector('[data-tab-count]');
                    if (cb) cb.classList.toggle('ef-tab__count--active', isActive);
                });
            }

            function renderCurrentTab() {
                const list = document.querySelector('.ef-orders__list');
                const ordersForTab = Object.values(allOrdersCache)
                    .filter(o => STATUS_TO_TAB[o.status] === currentTab);

                list.innerHTML = ordersForTab.length ?
                    ordersForTab.map(o => renderCard(o)).join('') :
                    renderEmpty(currentTab);
            }

            // ── Polling ──
            function poll() {
                fetch(`/customer/order/full-status?tab=all`)
                    .then(r => r.json())
                    .then(data => {
                        updateTabBadges(data.countByTab);

                        let needsRerender = false;
                        let needsTabSwitch = null; // null = tidak pindah, string = tab tujuan

                        data.orders.forEach(order => {
                            const cached = allOrdersCache[order.id];
                            if (!cached) {
                                allOrdersCache[order.id] = order;
                                if (STATUS_TO_TAB[order.status] === currentTab) needsRerender = true;
                            } else if (
                                cached.status !== order.status ||
                                cached.queue_number !== order.queue_number ||
                                cached.courier_name !== order.courier_name
                            ) {
                                const wasHere = STATUS_TO_TAB[cached.status] === currentTab;
                                const nowHere = STATUS_TO_TAB[order.status] === currentTab;
                                allOrdersCache[order.id] = order;
                                needsRerender = true;

                                if (wasHere && !nowHere) {
                                    // Ikuti order yang baru diproses ke tab tujuannya
                                    needsTabSwitch = STATUS_TO_TAB[order.status];
                                }
                            }
                        });

                        if (needsTabSwitch) {
                            switchTabUI(needsTabSwitch);
                        }

                        if (needsRerender) renderCurrentTab();

                    })
                    .catch(() => {});
            }

            // Inisialisasi cache dari DOM awal
            document.querySelectorAll('[data-order-id]').forEach(card => {
                const id = card.dataset.orderId;
                allOrdersCache[id] = {
                    id,
                    status: card.dataset.currentStatus,
                    rendered: true
                };
            });

            // Mulai polling
            setInterval(poll, 5000);

        }); // end DOMContentLoaded

        // ── Echo — chat badge realtime ──
        (function() {
            const authId = @json(auth()->id());
            const unreadMap = {};

            @foreach ($orders as $order)
                @if ($order->task?->courier)
                    @php
                        $unreadCount = \App\Models\Chat::where('sender_id', $order->task->courier->id)
                            ->where('receiver_id', auth()->id())
                            ->where('order_id', $order->id)
                            ->whereNull('read_at')
                            ->count();
                    @endphp
                    unreadMap['{{ $order->id }}'] = {{ $unreadCount }};
                @endif
            @endforeach

            function renderBadge(orderId, count) {
                const badge = document.getElementById('chat-badge-order-' + orderId);
                if (!badge) return;
                badge.textContent = count > 9 ? '9+' : count;
                badge.style.display = count > 0 ? 'inline-flex' : 'none';
            }

            Object.entries(unreadMap).forEach(([id, n]) => renderBadge(id, n));

            function waitForEcho(cb) {
                let attempts = 0;
                const iv = setInterval(() => {
                    attempts++;
                    if (window.Echo) {
                        clearInterval(iv);
                        cb();
                    }
                    if (attempts > 50) clearInterval(iv);
                }, 100);
            }

            waitForEcho(() => {
                window.Echo.private('user.{{ auth()->id() }}')
                    .listen('.chat.sent', (e) => {
                        if (String(e.chat.sender_id) === String(authId)) return;
                        const orderId = String(e.chat.order_id);
                        unreadMap[orderId] = (unreadMap[orderId] || 0) + 1;
                        renderBadge(orderId, unreadMap[orderId]);
                        window.NotifSystem?.notify('Pesan dari kurir', e.chat.message ?? '');
                    })
                    .listen('.chat.read', (e) => {
                        if (String(e.reader_id) !== String(authId)) return;
                        const orderId = String(e.order_id);
                        unreadMap[orderId] = 0;
                        renderBadge(orderId, 0);
                    });
            });
        })();
    </script> --}}
    <script>
        // ── Visibility reload ──
        let hiddenAt = null;
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'hidden') {
                hiddenAt = Date.now();
            } else if (document.visibilityState === 'visible') {
                if (hiddenAt && Date.now() - hiddenAt > 3000) location.reload();
            }
        });

        // ── unreadMap GLOBAL — dipakai oleh polling DAN Echo ──
        const unreadMap = {};

        // Isi unreadMap dari PHP saat halaman load
        @foreach ($orders as $order)
            @if ($order->task?->courier)
                @php
                    $unreadCount = \App\Models\Chat::where('sender_id', $order->task->courier->id)
                        ->where('receiver_id', auth()->id())
                        ->where('order_id', $order->id)
                        ->whereNull('read_at')
                        ->count();
                @endphp
                unreadMap['{{ $order->id }}'] = {{ $unreadCount }};
            @endif
        @endforeach

        function renderBadge(orderId, count) {
            const badge = document.getElementById('chat-badge-order-' + orderId);
            if (!badge) return;
            badge.textContent = count > 9 ? '9+' : count;
            badge.style.display = count > 0 ? 'inline-flex' : 'none';
            // Sync ke unreadMap supaya chatBtn() saat re-render pakai nilai terbaru
            unreadMap[String(orderId)] = count;
        }

        // Render badge awal dari unreadMap
        Object.entries(unreadMap).forEach(([id, n]) => renderBadge(id, n));

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

            const INFO_STYLE = {
                'confirmed': 'background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:8px 12px;margin:8px 0;font-size:.75rem;color:#1d4ed8;',
                'on_delivery': 'background:#fff7ed;border:1px solid #fed7aa;border-radius:8px;padding:8px 12px;margin:8px 0;font-size:.75rem;color:#c2410c;',
            };
            const INFO_ICON = {
                'confirmed': '✅',
                'on_delivery': '🚴'
            };
            const INFO_TEXT = {
                'confirmed': 'Pesanan dikonfirmasi dan sedang disiapkan.',
                'on_delivery': 'Pesanan sedang dalam perjalanan menuju lokasi kamu.',
            };

            const STATUS_TO_TAB = {
                'pending': 'pending',
                'confirmed': 'pending',
                'on_delivery': 'shipping',
                'completed': 'completed',
                'cancelled': 'cancelled',
            };

            // ── State ──
            let currentTab = new URLSearchParams(window.location.search).get('tab') || 'pending';
            let allOrdersCache = {};

            // ── Helpers ──
            function infoBanner(order) {
                if (!INFO_STYLE[order.status]) return '';
                const courierLine = order.courier_name ?
                    `<span style="display:block;margin-top:4px;font-weight:600;">🛵 Kurir: ${order.courier_name}</span>` :
                    '';
                return `<div style="${INFO_STYLE[order.status]}">${INFO_ICON[order.status]} ${INFO_TEXT[order.status]}${courierLine}</div>`;
            }

            function chatBtn(order) {
                if (!order.courier_id) return '';
                if (order.status !== 'confirmed' && order.status !== 'on_delivery') return '';
                // Pakai unreadMap GLOBAL
                const unread = unreadMap[String(order.id)] || 0;
                const badgeStyle = unread > 0 ?
                    'display:inline-flex;position:absolute;top:-6px;right:-6px;background:#ef4444;color:#fff;font-size:.55rem;font-weight:700;min-width:16px;height:16px;border-radius:999px;align-items:center;justify-content:center;padding:0 3px;border:2px solid #fff;line-height:1;' :
                    'display:none;position:absolute;top:-6px;right:-6px;background:#ef4444;color:#fff;font-size:.55rem;font-weight:700;min-width:16px;height:16px;border-radius:999px;align-items:center;justify-content:center;padding:0 3px;border:2px solid #fff;line-height:1;';
                return `
            <a href="/customer/chat/user/${order.courier_id}?order_id=${order.id}"
                class="ef-order-card__btn"
                id="chat-btn-order-${order.id}"
                data-courier-id="${order.courier_id}"
                style="text-decoration:none;display:inline-flex;align-items:center;gap:.3rem;background:#eff6ff;color:#2563eb;border:1px solid #dbeafe;position:relative;">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
                </svg>
                Chat Kurir
                <span id="chat-badge-order-${order.id}" style="${badgeStyle}">${unread > 9 ? '9+' : unread}</span>
            </a>`;
            }

            function actionButtons(order) {
                if (order.status === 'completed') {
                    return `<button class="ef-order-card__btn ef-order-card__btn--green">Pesan Lagi</button>`;
                }
                if (order.status === 'confirmed') return chatBtn(order);
                if (order.status === 'on_delivery') {
                    return `
                <div style="display:flex;gap:.4rem;align-items:center;">
                    <a href="/track/${order.order_code}"
                        class="ef-order-card__btn ef-order-card__btn--orange"
                        style="text-decoration:none;display:inline-flex;align-items:center;gap:.3rem;">
                        📍 Lacak
                    </a>
                    ${chatBtn(order)}
                </div>`;
                }
                return '';
            }

            function renderCard(order) {
                const display = STATUS_DISPLAY[order.status] ?? {
                    text: order.status,
                    color: 'gray',
                    icon: '?'
                };
                const itemSummary = (order.items || []).map(i => `${i.quantity} ${i.name}`).join(', ');
                const dotBadge = display.color === 'orange' ?
                    `<span class="ef-order-card__badge-dot"></span>${display.text}` :
                    display.text;
                const queueBadge = order.queue_number ?
                    `<p class="ef-order-card__queue" data-order-queue="${order.id}">
                    <span style="background:#1e293b;color:#fff;font-size:.65rem;font-weight:700;padding:2px 8px;border-radius:999px;">
                        Antrean #${order.queue_number}
                    </span>
               </p>` :
                    `<p class="ef-order-card__queue" data-order-queue="${order.id}" style="display:none"></p>`;

                return `
            <article class="ef-order-card ef-revealed"
                data-order-id="${order.id}"
                data-current-status="${order.status}">
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
                    <div data-order-info="${order.id}">${infoBanner(order)}</div>
                    <div class="ef-order-card__divider"></div>
                    <div class="ef-order-card__bottom">
                        <div class="ef-order-card__item">${itemSummary}</div>
                        <div class="ef-order-card__right">
                            <span class="ef-order-card__price">Rp${parseInt(order.total_amount).toLocaleString('id-ID')}</span>
                            ${actionButtons(order)}
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
            <div class="ef-orders__empty">
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
                    const cb = el.querySelector('[data-tab-count]');
                    if (cb) cb.classList.toggle('ef-tab__count--active', isActive);
                });
            }

            function renderCurrentTab() {
                const list = document.querySelector('.ef-orders__list');
                const ordersForTab = Object.values(allOrdersCache)
                    .filter(o => STATUS_TO_TAB[o.status] === currentTab);
                list.innerHTML = ordersForTab.length ?
                    ordersForTab.map(o => renderCard(o)).join('') :
                    renderEmpty(currentTab);

                // Re-render badge dari unreadMap setelah DOM baru dibuat
                Object.entries(unreadMap).forEach(([id, n]) => renderBadge(id, n));
            }

            // ── Polling ──
            function poll() {
                fetch(`/customer/order/full-status?tab=all`)
                    .then(r => r.json())
                    .then(data => {
                        updateTabBadges(data.countByTab);

                        let needsRerender = false;
                        let needsTabSwitch = null;

                        data.orders.forEach(order => {
                            const cached = allOrdersCache[order.id];
                            if (!cached) {
                                allOrdersCache[order.id] = order;
                                if (STATUS_TO_TAB[order.status] === currentTab) needsRerender = true;
                            } else if (
                                cached.status !== order.status ||
                                cached.queue_number !== order.queue_number ||
                                cached.courier_name !== order.courier_name
                            ) {
                                const wasHere = STATUS_TO_TAB[cached.status] === currentTab;
                                const nowHere = STATUS_TO_TAB[order.status] === currentTab;
                                allOrdersCache[order.id] = order;
                                needsRerender = true;
                                if (wasHere && !nowHere) needsTabSwitch = STATUS_TO_TAB[order.status];
                            }
                        });

                        if (needsTabSwitch) switchTabUI(needsTabSwitch);
                        if (needsRerender) renderCurrentTab();
                    })
                    .catch(() => {});
            }

            // Inisialisasi cache dari DOM awal
            document.querySelectorAll('[data-order-id]').forEach(card => {
                const id = card.dataset.orderId;
                allOrdersCache[id] = {
                    id,
                    status: card.dataset.currentStatus,
                    rendered: true
                };
            });

            setInterval(poll, 5000);

        }); // end DOMContentLoaded

        // ── Echo — SATU listener, pakai unreadMap GLOBAL ──
        (function() {
            const authId = @json(auth()->id());

            function waitForEcho(cb) {
                let attempts = 0;
                const iv = setInterval(() => {
                    attempts++;
                    if (window.Echo) {
                        clearInterval(iv);
                        cb();
                    }
                    if (attempts > 50) clearInterval(iv);
                }, 100);
            }

            //     function showEtaBanner(message) {
            //         document.getElementById('eta-banner')?.remove();
            //         const banner = document.createElement('div');
            //         banner.id = 'eta-banner';
            //         banner.style.cssText = `
        //     position:fixed;top:70px;left:50%;transform:translateX(-50%);
        //     background:#0f172a;color:#fff;padding:.75rem 1.2rem;
        //     border-radius:14px;font-size:.82rem;font-weight:600;
        //     box-shadow:0 8px 32px rgba(0,0,0,.25);z-index:9999;
        //     display:flex;align-items:center;gap:.6rem;
        //     max-width:calc(100vw - 2rem);
        //     animation:slideDown .3s cubic-bezier(.34,1.56,.64,1);
        // `;
            //         banner.innerHTML = `
        //     <style>
        //         @keyframes slideDown {
        //             from { opacity:0; transform:translateX(-50%) translateY(-12px); }
        //             to   { opacity:1; transform:translateX(-50%) translateY(0); }
        //         }
        //     </style>
        //     <span style="font-size:1.1rem;">🛵</span>
        //     <span>${message}</span>
        // `;
            //         document.body.appendChild(banner);
            //         setTimeout(() => {
            //             banner.style.opacity = '0';
            //             banner.style.transition = 'opacity .3s';
            //             setTimeout(() => banner.remove(), 300);
            //         }, 6000);
            //     }
            function showEtaBanner(message, type = 'nearby') {
                document.getElementById('eta-banner')?.remove();

                // const styles = {
                //     nearby: {
                //         bg: '#0f172a',
                //         icon: '🛵'
                //     }, // biru gelap - info
                //     arriving: {
                //         bg: '#c2410c',
                //         icon: '⏰'
                //     }, // orange - perhatian
                //     arrived: {
                //         bg: '#15803d',
                //         icon: '✅'
                //     }, // hijau - siap-siap
                // };
                const styles = {
                    departed: {
                        bg: '#2563eb',
                        icon: '🚀'
                    }, // biru - berangkat
                    nearby: {
                        bg: '#0f172a',
                        icon: '🛵'
                    },
                    arriving: {
                        bg: '#c2410c',
                        icon: '⏰'
                    },
                    arrived: {
                        bg: '#15803d',
                        icon: '✅'
                    },
                    delivered: {
                        bg: '#16a34a',
                        icon: '🎉'
                    }, // hijau cerah - selesai
                };
                const s = styles[type] || styles.nearby;
                const duration = type === 'arrived' ? 10000 : 6000;

                const banner = document.createElement('div');
                banner.id = 'eta-banner';
                banner.style.cssText = `
        position:fixed;top:70px;left:50%;transform:translateX(-50%);
        background:${s.bg};color:#fff;padding:.75rem 1.2rem;
        border-radius:14px;font-size:.82rem;font-weight:600;
        box-shadow:0 8px 32px rgba(0,0,0,.25);z-index:9999;
        display:flex;align-items:center;gap:.6rem;
        max-width:calc(100vw - 2rem);
        animation:slideDown .3s cubic-bezier(.34,1.56,.64,1);
    `;
                banner.innerHTML = `
        <style>
            @keyframes slideDown {
                from { opacity:0; transform:translateX(-50%) translateY(-12px); }
                to   { opacity:1; transform:translateX(-50%) translateY(0); }
            }
        </style>
        <span style="font-size:1.1rem;">${s.icon}</span>
        <span>${message}</span>
    `;
                document.body.appendChild(banner);
                setTimeout(() => {
                    banner.style.opacity = '0';
                    banner.style.transition = 'opacity .3s';
                    setTimeout(() => banner.remove(), 300);
                }, duration);
            }

            waitForEcho(() => {
                window.Echo.private('user.{{ auth()->id() }}')
                    .listen('.chat.sent', (e) => {
                        if (String(e.chat.sender_id) === String(authId)) return;
                        const orderId = String(e.chat.order_id);
                        unreadMap[orderId] = (unreadMap[orderId] || 0) + 1;
                        renderBadge(orderId, unreadMap[orderId]);
                        window.NotifSystem?.notify('Pesan dari kurir', e.chat.message ?? '');
                    })
                    .listen('.chat.read', (e) => {
                        if (String(e.reader_id) !== String(authId)) return;
                        const orderId = String(e.order_id);
                        unreadMap[orderId] = 0;
                        renderBadge(orderId, 0);
                    })
                    .listen('.courier.nearby', (e) => {
                        console.log('🛵 courier.nearby event diterima:', e); // ← tambah ini
                        if ('Notification' in window && Notification.permission === 'default') {
                            Notification.requestPermission();
                        }
                        if ('Notification' in window && Notification.permission === 'granted') {
                            new Notification('🛵 Update Pengiriman', {
                                body: e.message,
                                icon: '/favicon.ico',
                                tag: 'courier-eta',
                                vibrate: [200, 100, 200],
                            });
                        }
                        showEtaBanner(e.message, e.type);
                    });
            });
        })();
    </script>
</x-app-layout>
