<x-app-layout>
    <form action="{{ route('customer.checkout.process') }}" method="POST" id="checkoutForm">
        @csrf

        <div class="co-root">

            {{-- Header --}}
            <div class="co-header">
                <a href="javascript:history.back()" class="co-header__back" aria-label="Kembali">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                </a>
                <div class="co-header__center">
                    <span class="co-header__title">Checkout</span>
                    <span class="co-header__sub">Tinjau pesanan Anda</span>
                </div>
                <div class="co-header__step">
                    <span class="co-header__step-num">3</span>
                    <span class="co-header__step-txt">langkah</span>
                </div>
            </div>

            <div class="co-body">

                {{-- ── Progress Steps ── --}}
                <div class="co-progress">
                    <div class="co-progress__step co-progress__step--done">
                        <div class="co-progress__dot">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>
                        </div>
                        <span>Keranjang</span>
                    </div>
                    <div class="co-progress__line co-progress__line--done"></div>
                    <div class="co-progress__step co-progress__step--active">
                        <div class="co-progress__dot">
                            <div class="co-progress__dot-inner"></div>
                        </div>
                        <span>Checkout</span>
                    </div>
                    <div class="co-progress__line"></div>
                    <div class="co-progress__step">
                        <div class="co-progress__dot"></div>
                        <span>Selesai</span>
                    </div>
                </div>

                {{-- ── 1. Alamat Pengiriman ── --}}
                <div class="co-card" style="--card-delay: 0ms">
                    <div class="co-section-label">
                        <div class="co-section-label__badge co-section-label__badge--num">1</div>
                        <div class="co-section-label__icon co-section-label__icon--red">
                            <svg width="15" height="15" fill="none" stroke="#E8341A" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <span class="co-section-label__text">Alamat Pengiriman</span>
                    </div>

                    {{-- Hidden radio inputs — bawa data-* agar JS bisa update tampilan --}}
                    @php $defaultAddress = $addresses->firstWhere('is_default', true) ?? $addresses->first(); @endphp
                    @foreach ($addresses as $address)
                        <input type="radio" name="address_id" id="addr_{{ $address->id }}" value="{{ $address->id }}"
                            data-label="{{ $address->label }}" data-address="{{ $address->address }}"
                            data-is-default="{{ $address->is_default ? '1' : '0' }}" {{ $address->id == $defaultAddress?->id ? 'checked' : '' }} style="display:none">
                    @endforeach

                    {{-- Address row — sama padding dengan .co-select-list --}}
                    <div class="co-select-list" style="padding-bottom: 14px">
                        @if ($defaultAddress)
                            <a href="{{ route('customer.checkout.address-picker') }}" class="co-addr-row" id="addrRow">
                                <div class="co-addr-row__icon">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path
                                            d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div class="co-addr-row__body">
                                    <div class="co-addr-row__top">
                                        <span class="co-addr-row__label" id="addrLabel">{{ $defaultAddress->label }}</span>
                                        <span class="co-badge co-badge--blue co-addr-row__badge" id="addrBadge"
                                            style="{{ $defaultAddress->is_default ? '' : 'display:none' }}">Utama</span>
                                    </div>
                                    <p class="co-addr-row__detail" id="addrDetail">{{ $defaultAddress->address }}</p>
                                </div>
                                <div class="co-addr-row__chevron">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2"
                                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M9 18l6-6-6-6" />
                                    </svg>
                                </div>
                            </a>
                        @else
                            {{-- No address yet --}}
                            <a href="{{ route('customer.address.create') }}" class="co-addr-empty">
                                <div class="co-addr-empty__icon">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path
                                            d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div class="co-addr-empty__text">
                                    <span class="co-addr-empty__title">Belum ada alamat</span>
                                    <span class="co-addr-empty__sub">Tambah alamat pengiriman</span>
                                </div>
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2"
                                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M9 18l6-6-6-6" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>

                {{-- ── 2. Metode Pembayaran ── --}}
                <div class="co-card" style="--card-delay: 60ms">
                    <div class="co-section-label">
                        <div class="co-section-label__badge co-section-label__badge--num">2</div>
                        <div class="co-section-label__icon co-section-label__icon--blue">
                            <svg width="15" height="15" fill="none" stroke="#1A4A8A" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <rect x="2" y="5" width="20" height="14" rx="2" />
                                <path d="M2 10h20" />
                            </svg>
                        </div>
                        <span class="co-section-label__text">Metode Pembayaran</span>
                    </div>

                    <div class="co-select-list">

                        {{-- COD --}}
                        <label class="co-select-item co-pay-item">
                            <input type="radio" name="payment_method" value="cod" id="pay_cod" checked>
                            <div class="co-radio">
                                <div class="co-radio__dot"></div>
                            </div>
                            <div class="co-pay-icon co-pay-icon--cod">
                                <svg width="19" height="19" fill="none" stroke="#D97706" stroke-width="1.8"
                                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2" />
                                    <rect x="9" y="11" width="12" height="8" rx="2" />
                                    <circle cx="15" cy="15" r="1.5" />
                                </svg>
                            </div>
                            <div class="co-select-content">
                                <div class="co-select-content__top">
                                    <p class="co-select-label">Bayar di Tempat <span class="co-label-sub">(COD)</span>
                                    </p>
                                    <span class="co-badge co-badge--green">Populer</span>
                                </div>
                                <p class="co-select-sub">Bayar tunai saat barang tiba di tangan kamu</p>
                            </div>
                        </label>

                        {{-- Transfer Bank --}}
                        <label class="co-select-item co-pay-item">
                            <input type="radio" name="payment_method" value="transfer" id="pay_transfer">
                            <div class="co-radio">
                                <div class="co-radio__dot"></div>
                            </div>
                            <div class="co-pay-icon co-pay-icon--transfer">
                                <svg width="19" height="19" fill="none" stroke="#1A4A8A" stroke-width="1.8"
                                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <rect x="2" y="5" width="20" height="14" rx="2" />
                                    <path d="M2 10h20M6 15h4" />
                                </svg>
                            </div>
                            <div class="co-select-content">
                                <div class="co-select-content__top">
                                    <p class="co-select-label">Transfer Bank</p>
                                    <span class="co-badge co-badge--blue">Manual</span>
                                </div>
                                <p class="co-select-sub">BCA · Mandiri · BRI — konfirmasi manual</p>
                            </div>
                        </label>

                    </div>

                    {{-- Detail rekening transfer --}}
                    <div class="co-transfer-detail" id="transferDetail">
                        <div class="co-transfer-header">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <rect x="2" y="5" width="20" height="14" rx="2" />
                                <path d="M2 10h20" />
                            </svg>
                            Rekening Tujuan
                        </div>
                        <div class="co-transfer-banks">
                            @foreach ([['BCA', '1234567890'], ['Mandiri', '0987654321'], ['BRI', '1122334455']] as [$bank, $num])
                                <div class="co-transfer-bank">
                                    <div class="co-transfer-bank__left">
                                        <span class="co-transfer-bank__logo">{{ $bank }}</span>
                                        <span class="co-transfer-bank__num">{{ $num }}</span>
                                    </div>
                                    <button type="button" class="co-copy-btn" data-num="{{ $num }}">
                                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                            <rect x="9" y="9" width="13" height="13" rx="2" />
                                            <path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1" />
                                        </svg>
                                        Salin
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        <div class="co-transfer-note">
                            <div class="co-transfer-note__icon">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M12 16v-4M12 8h.01" />
                                </svg>
                            </div>
                            Transfer sesuai nominal total. Pesanan diproses setelah dikonfirmasi admin (maks. 1×24 jam).
                        </div>
                    </div>

                </div>

                {{-- ── 3. Daftar Produk ── --}}
                <div class="co-card" style="--card-delay: 120ms">
                    <div class="co-section-label">
                        <div class="co-section-label__badge co-section-label__badge--num">3</div>
                        <div class="co-section-label__icon co-section-label__icon--gray">
                            <svg width="15" height="15" fill="none" stroke="#4A4A4A" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4zM3 6h18" />
                                <path d="M16 10a4 4 0 01-8 0" />
                            </svg>
                        </div>
                        <span class="co-section-label__text">Daftar Produk</span>
                        <span class="co-item-count">{{ $order->items->count() }} item</span>
                    </div>

                    <div class="co-product-list">
                        @foreach ($order->items as $item)
                            <div class="co-product-item">
                                <div class="co-product-img-wrap">
                                    @if ($item->product->image)
                                        <img src="{{ asset('assets/icons/' . $item->product->image) }}"
                                            alt="{{ $item->product->name }}" class="co-product-img">
                                    @else
                                        <div class="co-product-img-placeholder">
                                            <svg width="20" height="20" fill="none" stroke="#CCCCCC" stroke-width="1.5"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="co-product-info">
                                    <p class="co-product-name">{{ $item->product->name }}</p>
                                    <div class="co-product-meta">
                                        <span class="co-product-qty-badge">× {{ $item->quantity }}</span>
                                        <span
                                            class="co-product-unit">Rp{{ number_format($item->product->price, 0, ',', '.') }}/pcs</span>
                                    </div>
                                </div>
                                <div class="co-product-subtotal">
                                    Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ── 4. Ringkasan Biaya ── --}}
                <div class="co-card" style="--card-delay: 180ms">
                    <div class="co-section-label">
                        <div class="co-section-label__badge co-section-label__badge--num">4</div>
                        <div class="co-section-label__icon co-section-label__icon--green">
                            <svg width="15" height="15" fill="none" stroke="#1A7A4A" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <line x1="12" y1="1" x2="12" y2="23" />
                                <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" />
                            </svg>
                        </div>
                        <span class="co-section-label__text">Ringkasan Biaya</span>
                    </div>

                    <div class="co-summary">
                        <div class="co-summary-row">
                            <span class="co-summary-label">Subtotal produk</span>
                            <span
                                class="co-summary-val">Rp{{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}</span>
                        </div>
                        <div class="co-summary-row">
                            <span class="co-summary-label">Ongkos kirim</span>
                            <span class="co-shipping-free">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M20 6L9 17l-5-5" />
                                </svg>
                                Gratis
                            </span>
                        </div>
                        <div class="co-summary-divider"></div>
                        <div class="co-summary-row co-summary-row--total">
                            <span class="co-summary-total-label">Total pembayaran</span>
                            <span
                                class="co-summary-total-val">Rp{{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="co-info-strip">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" style="flex-shrink:0">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 16v-4M12 8h.01" />
                        </svg>
                        Pembayaran dilakukan setelah pesanan dikonfirmasi kurir
                    </div>
                </div>

                <x-flash-toast />

            </div>
        </div>

        {{-- Footer sticky --}}
        <div class="co-footer">
            <div class="co-footer__inner">
                <div class="co-footer__total">
                    <p class="co-footer__total-label">Total pembayaran</p>
                    <p class="co-footer__total-val">
                        Rp{{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}
                    </p>
                </div>
                <button type="submit" class="co-footer__btn">
                    Buat Pesanan
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

    </form>

    {{-- ── Leave Page Confirmation Sheet ── --}}
    <div class="ef-sheet-overlay" id="leaveSheet" role="dialog" aria-modal="true">
        <div class="ef-sheet" id="leaveSheetBox">
            <div class="ef-sheet__pill"></div>
            <div class="ef-sheet__icon" style="background:#fffbeb;border-color:rgba(217,119,6,.18);color:#d97706">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                    <line x1="12" y1="9" x2="12" y2="13" />
                    <line x1="12" y1="17" x2="12.01" y2="17" />
                </svg>
            </div>
            <h3 class="ef-sheet__title">Tinggalkan halaman ini?</h3>
            <p class="ef-sheet__body">Perubahan yang belum disimpan akan hilang.</p>
            <div class="ef-sheet__actions">
                <button class="ef-sheet__btn-cancel" id="leaveStay"
                    style="background:linear-gradient(135deg,#2563eb,#1d4ed8);color:#fff;font-weight:800;box-shadow:0 4px 14px rgba(37,99,235,.35)">
                    Tetap di Halaman Ini
                </button>
                <button class="ef-sheet__btn-cancel" id="leaveConfirm" style="color:#e11d48">
                    Ya, Tinggalkan
                </button>
            </div>
        </div>
    </div>

    <script>
        // ─────────────────────────────────────────────────────────────
        // CONSTANTS
        // ─────────────────────────────────────────────────────────────
        const CHECKOUT_STATE_KEY = 'checkout_state';

        const CHECKOUT_FLOW_PATHS = [
            '/customer/checkout/address-picker',
            '/customer/address/create',
        ];

        // ─────────────────────────────────────────────────────────────
        // HELPERS
        // ─────────────────────────────────────────────────────────────
        function isCheckoutFlow(href) {
            if (!href) return false;
            return CHECKOUT_FLOW_PATHS.some(path => href.includes(path));
        }

        function toggleTransfer() {
            const selected = document.querySelector('input[name="payment_method"]:checked');
            document.getElementById('transferDetail')
                .classList.toggle('visible', selected?.value === 'transfer');
        }

        function saveCheckoutState() {
            const state = {
                address_id: document.querySelector('input[name="address_id"]:checked')?.value ?? null,
                payment_method: document.querySelector('input[name="payment_method"]:checked')?.value ?? 'cod',
                saved_at: Date.now(),
            };
            localStorage.setItem(CHECKOUT_STATE_KEY, JSON.stringify(state));
        }

        function restoreCheckoutState() {
            const raw = localStorage.getItem(CHECKOUT_STATE_KEY);
            if (!raw) return;
            let state;
            try { state = JSON.parse(raw); } catch { return; }
            if (Date.now() - (state.saved_at ?? 0) > 30 * 60 * 1000) {
                localStorage.removeItem(CHECKOUT_STATE_KEY);
                return;
            }
            if (state.address_id) {
                const r = document.querySelector(`input[name="address_id"][value="${state.address_id}"]`);
                if (r) r.checked = true;
            }
            if (state.payment_method) {
                const r = document.querySelector(`input[name="payment_method"][value="${state.payment_method}"]`);
                if (r) { r.checked = true; toggleTransfer(); }
            }
            localStorage.removeItem(CHECKOUT_STATE_KEY);
        }

        // ─────────────────────────────────────────────────────────────
        // LEAVE GUARD STATE — di luar DOMContentLoaded agar konsisten
        // ─────────────────────────────────────────────────────────────
        let pendingNav = null;
        let formDirty = false;
        let isSubmitting = false;

        // ─────────────────────────────────────────────────────────────
        // MAIN
        // ─────────────────────────────────────────────────────────────
        document.addEventListener('DOMContentLoaded', () => {

            // Bersihkan address-picker dari history stack
            if (document.referrer.includes('/checkout/address-picker')) {
                history.replaceState(null, '', window.location.href);
            }

            // ── Restore alamat dari address-picker (sessionStorage) ───
            const chosenId = sessionStorage.getItem('chosen_address_id');
            if (chosenId) {
                sessionStorage.removeItem('chosen_address_id');
                const radio = document.getElementById('addr_' + chosenId);
                if (radio) {
                    document.querySelectorAll('input[name="address_id"]').forEach(r => r.checked = false);
                    radio.checked = true;
                    const elLabel = document.getElementById('addrLabel');
                    const elDetail = document.getElementById('addrDetail');
                    const elBadge = document.getElementById('addrBadge');
                    if (elLabel) elLabel.textContent = radio.dataset.label;
                    if (elDetail) elDetail.textContent = radio.dataset.address;
                    if (elBadge) elBadge.style.display = radio.dataset.isDefault === '1' ? '' : 'none';

                    formDirty = true; // ← user sudah pilih alamat berbeda

                }
            }

            // Restore dari localStorage (kembali dari tambah alamat)
            restoreCheckoutState();

            // ── Payment method ────────────────────────────────────────
            document.querySelectorAll('input[name="payment_method"]')
                .forEach(r => r.addEventListener('change', toggleTransfer));
            toggleTransfer();

            // ── Copy nomor rekening ───────────────────────────────────
            document.querySelectorAll('.co-copy-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    navigator.clipboard.writeText(btn.dataset.num).then(() => {
                        const original = btn.innerHTML;
                        btn.innerHTML = `<svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M20 6L9 17l-5-5"/></svg> Tersalin`;
                        btn.classList.add('copied');
                        setTimeout(() => { btn.innerHTML = original; btn.classList.remove('copied'); }, 2000);
                    });
                });
            });

            // ── Submit — loading state ────────────────────────────────
            document.getElementById('checkoutForm').addEventListener('submit', function () {
                isSubmitting = true;
                const btn = this.querySelector('.co-footer__btn');
                btn.disabled = true;
                btn.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.2" stroke-linecap="round" class="co-spin">
                <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83
                         M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
            </svg> Memproses...`;
            });

            // Simpan state sebelum navigasi ke tambah alamat
            document.querySelector('.co-addr-add')?.addEventListener('click', saveCheckoutState);

            // ── Leave Guard ───────────────────────────────────────────
            const leaveSheet = document.getElementById('leaveSheet');
            const leaveSheetBox = document.getElementById('leaveSheetBox');
            const leaveStay = document.getElementById('leaveStay');
            const leaveConfirm = document.getElementById('leaveConfirm');

            // Tandai dirty saat user mengubah pilihan
            document.querySelectorAll('input[name="payment_method"], input[name="address_id"]')
                .forEach(el => el.addEventListener('change', () => { formDirty = true; }));

            function openLeaveSheet(nav) {
                pendingNav = nav;
                leaveSheet.classList.add('open');
            }

            function closeLeaveSheet(callback) {
                leaveSheetBox.style.animation = 'efSheetDown .22s cubic-bezier(.4,0,1,1) forwards';
                setTimeout(() => {
                    leaveSheet.classList.remove('open');
                    leaveSheetBox.style.animation = '';
                    callback?.();
                }, 220);
            }

            function doNavigate(nav) {
                isSubmitting = true;
                if (!nav || nav === '__back__') history.back();
                else window.location.href = nav;
            }

            leaveStay.addEventListener('click', () => closeLeaveSheet());
            leaveConfirm.addEventListener('click', () => closeLeaveSheet(() => doNavigate(pendingNav)));

            // ── Khusus tombol back — href="javascript:..." ────────────
            // Tidak bisa diintercept via href check, harus listener sendiri
            document.querySelector('.co-header__back')?.addEventListener('click', e => {
                if (isSubmitting || !formDirty) return;
                e.preventDefault();
                e.stopImmediatePropagation();
                openLeaveSheet('__back__');
            });

            // ── Intercept link <a> biasa (navbar, dll) ────────────────
            document.addEventListener('click', e => {
                if (isSubmitting || !formDirty) return;

                const link = e.target.closest('a[href]');
                if (!link) return;

                // Skip tombol back — sudah dihandle di atas
                if (link.classList.contains('co-header__back')) return;

                const href = link.getAttribute('href');
                if (!href) return;

                // Skip: anchor, javascript:, target blank, flow checkout
                if (
                    href.startsWith('#') ||
                    href.startsWith('javascript') ||
                    link.target === '_blank' ||
                    isCheckoutFlow(href)
                ) return;

                e.preventDefault();
                e.stopImmediatePropagation();
                openLeaveSheet(href);
            });

        });
    </script>
</x-app-layout>