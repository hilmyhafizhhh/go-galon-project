<x-app-layout>
    <div class="ef-cart" id="cartRoot">

        {{-- ══════════════════════════════
        HEADER — default & selection mode
        ══════════════════════════════ --}}
        <div class="ef-cart__header">
            <div class="ef-cart__header-inner">

                {{-- Default --}}
                <div class="ef-cart__header-default" id="headerDefault">
                    <div>
                        <h1 class="ef-cart__title">Keranjang</h1>
                        <p class="ef-cart__subtitle">
                            @if (!$order || $order->items->isEmpty())
                                Belum ada item
                            @else
                                {{ $order->items->count() }} produk
                            @endif
                        </p>
                    </div>
                    <div class="ef-cart__header-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1" />
                            <circle cx="20" cy="21" r="1" />
                            <path d="M1 1h4l2.68 13.39A2 2 0 009.66 16h9.72a2 2 0 001.99-1.61L23 6H6" />
                        </svg>
                    </div>
                </div>

                {{-- Selection / delete mode --}}
                <div class="ef-cart__header-select" id="headerSelect" style="display:none">
                    <button class="ef-cart__cancel-btn" id="cancelSelectBtn">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6L6 18M6 6l12 12" />
                        </svg>
                        Batal
                    </button>
                    <span class="ef-cart__select-info" id="selectInfo">0 dipilih</span>
                    <button class="ef-cart__delete-btn" id="deleteSelectedBtn">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6" />
                            <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                            <path d="M10 11v6M14 11v6" />
                            <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2" />
                        </svg>
                        Hapus
                    </button>
                </div>

            </div>
        </div>

        {{-- ══════════════════════════════
        BODY
        ══════════════════════════════ --}}
        <div class="ef-cart__body">

            @if (!$order || $order->items->isEmpty())

                <div class="ef-cart__empty" data-reveal>
                    <div class="ef-cart__empty-visual">
                        <div class="ef-cart__empty-ring ef-cart__empty-ring--outer"></div>
                        <div class="ef-cart__empty-ring ef-cart__empty-ring--inner"></div>
                        <div class="ef-cart__empty-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1" />
                                <circle cx="20" cy="21" r="1" />
                                <path d="M1 1h4l2.68 13.39A2 2 0 009.66 16h9.72a2 2 0 001.99-1.61L23 6H6" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="ef-cart__empty-title">Keranjang masih kosong</h3>
                    <p class="ef-cart__empty-sub">Tambahkan produk galon favoritmu ke keranjang.</p>
                    <a href="{{ route('customer.home') }}" class="ef-cart__empty-btn">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.5z" />
                            <path d="M9 21V12h6v9" />
                        </svg>
                        Lihat Produk
                    </a>
                </div>

            @else

                <div class="ef-cart__list" id="cartList">
                    @foreach ($order->items as $item)
                        <div class="ef-cart__item" data-reveal data-delay="{{ $loop->index * 55 }}"
                            data-item-id="{{ $item->id }}">

                            {{-- Checkbox --}}
                            <label class="ef-cart__check-wrap">
                                <input type="checkbox" class="item-checkbox ef-cart__checkbox" data-id="{{ $item->id }}"
                                    data-price="{{ $item->product->price }}" data-qty="{{ $item->quantity }}">
                                <span class="ef-cart__checkmark">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="white"
                                        stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 6L9 17l-5-5" />
                                    </svg>
                                </span>
                            </label>

                            {{-- Image --}}
                            <div class="ef-cart__img-wrap">
                                <img src="{{ asset('assets/icons/' . $item->product->image) }}" alt="{{ $item->product->name }}"
                                    class="ef-cart__img">
                            </div>

                            {{-- Info --}}
                            <div class="ef-cart__info">
                                <h3 class="ef-cart__name">{{ $item->product->name }}</h3>
                                <p class="ef-cart__meta">Galon premium · Siap antar</p>
                                <p class="ef-cart__price">
                                    Rp{{ number_format($item->product->price, 0, ',', '.') }}
                                </p>
                            </div>

                            {{-- Right: qty + hapus --}}
                            <div class="ef-cart__right">
                                <div class="ef-cart__qty" data-item-id="{{ $item->id }}"
                                    data-price="{{ $item->product->price }}">
                                    <button class="ef-cart__qty-btn ef-cart__qty-btn--minus" aria-label="Kurangi">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2.5" stroke-linecap="round">
                                            <path d="M5 12h14" />
                                        </svg>
                                    </button>
                                    <span class="ef-cart__qty-val">{{ $item->quantity }}</span>
                                    <button class="ef-cart__qty-btn ef-cart__qty-btn--plus" aria-label="Tambah">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2.5" stroke-linecap="round">
                                            <path d="M12 5v14M5 12h14" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

                <div style="height:104px"></div>

            @endif
        </div>

        {{-- ══════════════════════════════
        STICKY FOOTER
        ══════════════════════════════ --}}
        @if ($order && $order->items->isNotEmpty())
            <div class="ef-cart__footer">
                <div class="ef-cart__footer-inner">
                    <label class="ef-cart__check-wrap ef-cart__check-wrap--footer">
                        <input type="checkbox" id="checkAll" class="ef-cart__checkbox">
                        <span class="ef-cart__checkmark">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>
                        </span>
                        <span class="ef-cart__all-label">Semua</span>
                    </label>

                    <div class="ef-cart__total">
                        <span class="ef-cart__total-label">Total</span>
                        <span id="totalPrice" class="ef-cart__total-val">Rp0</span>
                    </div>

                    <button id="checkoutBtn" class="ef-cart__checkout ef-cart__checkout--disabled" disabled>
                        Checkout
                        <span id="checkoutCount" class="ef-cart__checkout-badge">0</span>
                    </button>
                </div>
            </div>
        @endif

    </div>

    {{-- ══════════════════════════════
    CONFIRM DIALOG
    ══════════════════════════════ --}}
    <div id="confirmDialog" class="ef-dialog" aria-modal="true" role="dialog" style="display:none">
        <div class="ef-dialog__backdrop" id="dialogBackdrop"></div>
        <div class="ef-dialog__box">
            <div class="ef-dialog__icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6" />
                    <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                    <path d="M10 11v6M14 11v6" />
                    <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2" />
                </svg>
            </div>
            <h3 class="ef-dialog__title" id="dialogTitle">Hapus item?</h3>
            <p class="ef-dialog__body" id="dialogBody">Item akan dihapus dari keranjang.</p>
            <div class="ef-dialog__actions">
                <button class="ef-dialog__btn ef-dialog__btn--cancel" id="dialogCancel">Batal</button>
                <button class="ef-dialog__btn ef-dialog__btn--confirm" id="dialogConfirm">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6" />
                        <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                    </svg>
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>

    {{-- Toast --}}
    <div id="ef-toast-container" aria-live="polite"></div>

    {{-- ══════════════════════════════
    SCRIPTS
    ══════════════════════════════ --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // ── Scroll reveal ──────────────────────────────────────────
            const revealObs = new IntersectionObserver((entries) => {
                entries.forEach(e => {
                    if (!e.isIntersecting) return;
                    setTimeout(() => e.target.classList.add('ef-revealed'), parseInt(e.target.dataset.delay || 0));
                    revealObs.unobserve(e.target);
                });
            }, { threshold: 0.06 });
            document.querySelectorAll('[data-reveal]').forEach(el => revealObs.observe(el));

            // ── DOM refs ───────────────────────────────────────────────
            const checkAll = document.getElementById('checkAll');
            if (!checkAll) return;

            const totalPriceEl = document.getElementById('totalPrice');
            const checkoutBtn = document.getElementById('checkoutBtn');
            const checkoutCount = document.getElementById('checkoutCount');
            const headerDefault = document.getElementById('headerDefault');
            const headerSelect = document.getElementById('headerSelect');
            const selectInfo = document.getElementById('selectInfo');
            const deleteSelBtn = document.getElementById('deleteSelectedBtn');
            const cancelSelBtn = document.getElementById('cancelSelectBtn');
            const cartList = document.getElementById('cartList');
            const dialog = document.getElementById('confirmDialog');
            const dialogTitle = document.getElementById('dialogTitle');
            const dialogBody = document.getElementById('dialogBody');
            const dialogConfirm = document.getElementById('dialogConfirm');
            const dialogCancel = document.getElementById('dialogCancel');
            const dialogBdrop = document.getElementById('dialogBackdrop');
            const toastEl = document.getElementById('ef-toast-container');

            // ── Getters ────────────────────────────────────────────────
            const getItemCBs = () => [...document.querySelectorAll('.item-checkbox')];

            // ── Update cart state ──────────────────────────────────────
            function updateCart() {
                const cbs = getItemCBs();
                let total = 0, countQty = 0, countChecked = 0;

                cbs.forEach(cb => {
                    if (cb.checked) {
                        total += parseInt(cb.dataset.price) * parseInt(cb.dataset.qty);
                        countQty += parseInt(cb.dataset.qty);
                        countChecked++;
                    }
                });

                // Footer
                totalPriceEl.textContent = 'Rp' + total.toLocaleString('id-ID');
                checkoutCount.textContent = countQty;
                checkoutBtn.disabled = countQty === 0;
                checkoutBtn.classList.toggle('ef-cart__checkout--disabled', countQty === 0);

                // Header mode
                if (countChecked > 0) {
                    headerDefault.style.display = 'none';
                    headerSelect.style.display = 'flex';
                    selectInfo.textContent = `${countChecked} item dipilih`;
                } else {
                    headerDefault.style.display = 'flex';
                    headerSelect.style.display = 'none';
                }

                // Indeterminate "select all"
                const allChecked = cbs.length > 0 && cbs.every(c => c.checked);
                const someChecked = cbs.some(c => c.checked);
                checkAll.checked = allChecked;
                checkAll.indeterminate = someChecked && !allChecked;
            }

            // ── Checkbox events ────────────────────────────────────────
            checkAll.addEventListener('change', function () {
                getItemCBs().forEach(cb => cb.checked = this.checked);
                updateCart();
            });

            cartList.addEventListener('change', e => {
                if (!e.target.classList.contains('item-checkbox')) return;
                updateCart();
            });

            // ── Cancel selection ───────────────────────────────────────
            cancelSelBtn.addEventListener('click', () => {
                getItemCBs().forEach(cb => cb.checked = false);
                checkAll.checked = false;
                updateCart();
            });

            // ── Toast ──────────────────────────────────────────────────
            function showToast(msg, type = 'success') {
                const t = document.createElement('div');
                t.className = `ef-toast ef-toast--${type}`;
                const svgPath = type === 'success'
                    ? '<path d="M20 6L9 17l-5-5"/>'
                    : '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>';
                t.innerHTML = `
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">${svgPath}</svg>
            <span>${msg}</span>`;
                toastEl.prepend(t);
                requestAnimationFrame(() => t.classList.add('ef-toast--show'));
                setTimeout(() => {
                    t.classList.remove('ef-toast--show');
                    setTimeout(() => t.remove(), 380);
                }, 2800);
            }

            // ── Dialog ─────────────────────────────────────────────────
            function openDialog(title, body, onConfirm) {
                dialogTitle.textContent = title;
                dialogBody.textContent = body;
                dialog.style.display = 'flex';
                requestAnimationFrame(() => dialog.classList.add('ef-dialog--open'));

                function cleanup() {
                    dialogConfirm.removeEventListener('click', handleConfirm);
                    dialogCancel.removeEventListener('click', handleCancel);
                    dialogBdrop.removeEventListener('click', handleCancel);
                }
                function handleConfirm() { cleanup(); closeDialog(); onConfirm(); }
                function handleCancel() { cleanup(); closeDialog(); }

                dialogConfirm.addEventListener('click', handleConfirm);
                dialogCancel.addEventListener('click', handleCancel);
                dialogBdrop.addEventListener('click', handleCancel);
            }

            function closeDialog() {
                dialog.classList.remove('ef-dialog--open');
                setTimeout(() => { dialog.style.display = 'none'; }, 280);
            }

            // ── Animate item out ───────────────────────────────────────
            function animateOut(el, done) {
                el.classList.add('ef-cart__item--removing');
                el.addEventListener('transitionend', () => { el.remove(); done && done(); }, { once: true });
            }

            // ── Delete via API ─────────────────────────────────────────
            function deleteItems(ids, els, successMsg) {
                // Optimistic: animate items out immediately
                let removed = 0;
                els.forEach(el => animateOut(el, () => {
                    removed++;
                    if (removed === els.length) {
                        if (document.querySelectorAll('.ef-cart__item').length === 0) {
                            setTimeout(() => location.reload(), 300);
                        } else {
                            updateCart();
                        }
                    }
                }));

                fetch('/customer/cart/remove', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ item_ids: ids })
                })
                    .then(r => { if (!r.ok) throw new Error(); return r.json(); })
                    .then(() => showToast(successMsg))
                    .catch(() => {
                        showToast('Gagal menghapus. Halaman akan dimuat ulang.', 'error');
                        setTimeout(() => location.reload(), 1200);
                    });
            }

            // ── Single delete ──────────────────────────────────────────
            cartList.addEventListener('click', e => {
                const btn = e.target.closest('.ef-cart__item-del');
                if (!btn) return;
                const id = btn.dataset.itemId;
                const name = btn.dataset.name;
                const el = btn.closest('.ef-cart__item');

                openDialog(
                    'Hapus dari keranjang?',
                    `"${name}" akan dihapus dari keranjangmu.`,
                    () => deleteItems([id], [el], `${name} dihapus`)
                );
            });

            // ── Bulk delete ────────────────────────────────────────────
            deleteSelBtn.addEventListener('click', () => {
                const checked = getItemCBs().filter(cb => cb.checked);
                if (!checked.length) return;

                const ids = checked.map(cb => cb.dataset.id);
                const els = checked.map(cb => cb.closest('.ef-cart__item'));
                const noun = ids.length > 1 ? `${ids.length} item` : `1 item`;

                openDialog(
                    `Hapus ${noun}?`,
                    `${noun} yang dipilih akan dihapus dari keranjangmu. Tindakan ini tidak bisa dibatalkan.`,
                    () => {
                        checkAll.checked = false;
                        deleteItems(ids, els, `${noun} berhasil dihapus`);
                    }
                );
            });

            // ── Qty stepper ────────────────────────────────────────────
            cartList.addEventListener('click', e => {
                const minus = e.target.closest('.ef-cart__qty-btn--minus');
                const plus = e.target.closest('.ef-cart__qty-btn--plus');
                if (!minus && !plus) return;

                const qtyWrap = e.target.closest('.ef-cart__qty');
                const valEl = qtyWrap.querySelector('.ef-cart__qty-val');
                const cb = qtyWrap.closest('.ef-cart__item').querySelector('.item-checkbox');
                let val = parseInt(valEl.textContent);

                if (minus) val = Math.max(1, val - 1);
                if (plus) val = val + 1;

                valEl.textContent = val;
                cb.dataset.qty = val;
                updateCart();
            });

            updateCart();
        });
    </script>


</x-app-layout>