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

                    <div class="co-select-list" id="addressList">
                        @foreach ($addresses as $index => $address)
                            <label class="co-select-item {{ $index >= 2 ? 'addr-hidden' : '' }}"
                                style="{{ $index >= 2 ? 'display:none' : '' }}">
                                <input type="radio" name="address_id" value="{{ $address->id }}" {{ $address->is_default ? 'checked' : '' }}>
                                <div class="co-radio">
                                    <div class="co-radio__dot"></div>
                                </div>
                                <div class="co-select-content">
                                    <div class="co-select-content__top">
                                        <p class="co-select-label">{{ $address->label }}</p>
                                        @if ($address->is_default)
                                            <span class="co-badge co-badge--red">Utama</span>
                                        @endif
                                    </div>
                                    <p class="co-select-sub">{{ $address->address }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    @if ($addresses->count() > 2)
                        <button type="button" class="co-show-more" id="toggleAddressBtn">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                            Lihat {{ $addresses->count() - 2 }} alamat lainnya
                        </button>
                    @endif

                    <div class="co-card-footer">
                        <a href="{{ route('customer.address.create') }}" class="co-addr-add">
                            <div class="co-addr-add__icon">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"
                                    stroke-linecap="round" viewBox="0 0 24 24">
                                    <path d="M12 5v14M5 12h14" />
                                </svg>
                            </div>
                            Tambah alamat baru
                        </a>
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

                @if (session('success'))
                    <div class="co-alert co-alert--success">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M20 6L9 17l-5-5" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

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

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const payRadios = document.querySelectorAll('input[name="payment_method"]');
            const transferDetail = document.getElementById('transferDetail');

            function toggleTransfer() {
                const selected = document.querySelector('input[name="payment_method"]:checked');
                transferDetail.classList.toggle('visible', selected?.value === 'transfer');
            }

            payRadios.forEach(r => r.addEventListener('change', toggleTransfer));
            toggleTransfer();

            document.querySelectorAll('.co-copy-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const num = btn.dataset.num;
                    navigator.clipboard.writeText(num).then(() => {
                        btn.innerHTML = `<svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg> Tersalin`;
                        btn.classList.add('copied');
                        setTimeout(() => {
                            btn.innerHTML = `<svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg> Salin`;
                            btn.classList.remove('copied');
                        }, 2000);
                    });
                });
            });

            const toggleBtn = document.getElementById('toggleAddressBtn');
            if (toggleBtn) {
                toggleBtn.addEventListener('click', () => {
                    const hidden = document.querySelectorAll('.addr-hidden');
                    const isExpanded = toggleBtn.classList.contains('expanded');

                    hidden.forEach(el => el.style.display = isExpanded ? 'none' : '');
                    toggleBtn.classList.toggle('expanded', !isExpanded);

                    const remaining = {{ $addresses->count() - 2 }};
                    toggleBtn.innerHTML = isExpanded
                        ? `<svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg> Lihat ${remaining} alamat lainnya`
                        : `<svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M18 15l-6-6-6 6"/></svg> Sembunyikan`;
                });
            }

            // Submit button loading state
            document.getElementById('checkoutForm').addEventListener('submit', function () {
                const btn = this.querySelector('.co-footer__btn');
                btn.disabled = true;
                btn.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" class="co-spin"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg> Memproses...`;
            });

            // Tambahkan di paling bawah:
            document.querySelector('.co-addr-add')?.addEventListener('click', saveCheckoutState);
            restoreCheckoutState();

        });


        // ── Simpan & restore state checkout via localStorage ──

        const CHECKOUT_STATE_KEY = 'checkout_state';

        // Simpan state sebelum navigasi ke halaman lain
        function saveCheckoutState() {
            const addressSelected = document.querySelector('input[name="address_id"]:checked');
            const paymentSelected = document.querySelector('input[name="payment_method"]:checked');

            const state = {
                address_id: addressSelected?.value ?? null,
                payment_method: paymentSelected?.value ?? 'cod',
                saved_at: Date.now(),
            };

            localStorage.setItem(CHECKOUT_STATE_KEY, JSON.stringify(state));
        }

        // Restore state saat halaman dimuat
        function restoreCheckoutState() {
            const raw = localStorage.getItem(CHECKOUT_STATE_KEY);
            if (!raw) return;

            let state;
            try { state = JSON.parse(raw); } catch { return; }

            // Expired setelah 30 menit — jangan restore state lama
            if (Date.now() - (state.saved_at ?? 0) > 30 * 60 * 1000) {
                localStorage.removeItem(CHECKOUT_STATE_KEY);
                return;
            }

            // Restore alamat
            if (state.address_id) {
                const addrRadio = document.querySelector(`input[name="address_id"][value="${state.address_id}"]`);
                if (addrRadio) addrRadio.checked = true;
            }

            // Restore metode bayar
            if (state.payment_method) {
                const payRadio = document.querySelector(`input[name="payment_method"][value="${state.payment_method}"]`);
                if (payRadio) {
                    payRadio.checked = true;
                    toggleTransfer(); // panggil ulang agar detail rekening muncul/sembunyi sesuai pilihan
                }
            }

            // Hapus setelah di-restore — bersih
            localStorage.removeItem(CHECKOUT_STATE_KEY);
        }

        // Pasang listener ke link "Tambah alamat baru"
        document.querySelector('.co-addr-add')?.addEventListener('click', saveCheckoutState);

        // Jalankan restore saat DOM ready (sudah di dalam DOMContentLoaded, jadi langsung panggil)
        restoreCheckoutState();

    </script>
</x-app-layout>