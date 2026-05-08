<x-app-layout>
    <form action="{{ route('customer.checkout.process') }}" method="POST" id="checkoutForm">
        @csrf

        <div class="co-root">

            {{-- Header --}}
            <div class="co-header">
                <a href="javascript:history.back()" class="co-header__back">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                </a>
                <span class="co-header__title">Checkout</span>
                <span class="co-header__step">3 langkah</span>
            </div>

            <div class="co-body">

                {{-- ── 1. Alamat Pengiriman ── --}}
                <div class="co-card">
                    <div class="co-section-label">
                        <div class="co-section-label__icon co-section-label__icon--red">
                            <svg width="14" height="14" fill="none" stroke="#E8341A" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <span class="co-section-label__text">Alamat Pengiriman</span>
                    </div>

                    <div class="co-select-list">
                        @foreach ($addresses as $address)
                            <label class="co-select-item">
                                <input type="radio" name="address_id" value="{{ $address->id }}"
                                    {{ $address->is_default ? 'checked' : '' }}>
                                <div class="co-select-dot"></div>
                                <div style="flex:1; min-width:0">
                                    <p class="co-select-label">{{ $address->label }}</p>
                                    <p class="co-select-sub">{{ $address->address }}</p>
                                </div>
                                @if ($address->is_default)
                                    <span class="co-select-badge co-select-badge--red">Utama</span>
                                @endif
                            </label>
                        @endforeach
                    </div>

                    <a href="{{ route('customer.address.create') }}" class="co-addr-add">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" viewBox="0 0 24 24">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                        Tambah alamat baru
                    </a>
                </div>

                {{-- ── 2. Metode Pembayaran ── --}}
                <div class="co-card">
                    <div class="co-section-label">
                        <div class="co-section-label__icon co-section-label__icon--blue">
                            <svg width="14" height="14" fill="none" stroke="#1A4A8A" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <rect x="2" y="5" width="20" height="14" rx="2" />
                                <path d="M2 10h20" />
                            </svg>
                        </div>
                        <span class="co-section-label__text">Metode Pembayaran</span>
                    </div>

                    <div class="co-select-list">

                        {{-- COD --}}
                        <label class="co-select-item">
                            <input type="radio" name="payment_method" value="cod" id="pay_cod" checked>
                            <div class="co-select-dot"></div>
                            <div class="co-pay-icon co-pay-icon--cod">
                                <svg width="18" height="18" fill="none" stroke="#D97706" stroke-width="1.8"
                                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2" />
                                    <rect x="9" y="11" width="12" height="8" rx="2" />
                                    <circle cx="15" cy="15" r="1.5" />
                                </svg>
                            </div>
                            <div style="flex:1; min-width:0">
                                <p class="co-select-label">Bayar di Tempat (COD)</p>
                                <p class="co-select-sub">Bayar tunai saat barang tiba di tangan kamu</p>
                            </div>
                            <span class="co-select-badge co-select-badge--green">Populer</span>
                        </label>

                        {{-- Transfer Bank --}}
                        <label class="co-select-item">
                            <input type="radio" name="payment_method" value="transfer" id="pay_transfer">
                            <div class="co-select-dot"></div>
                            <div class="co-pay-icon co-pay-icon--transfer">
                                <svg width="18" height="18" fill="none" stroke="#1A4A8A" stroke-width="1.8"
                                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <rect x="2" y="5" width="20" height="14" rx="2" />
                                    <path d="M2 10h20M6 15h4" />
                                </svg>
                            </div>
                            <div style="flex:1; min-width:0">
                                <p class="co-select-label">Transfer Bank</p>
                                <p class="co-select-sub">BCA · Mandiri · BRI — konfirmasi manual</p>
                            </div>
                            <span class="co-select-badge co-select-badge--blue">Manual</span>
                        </label>

                    </div>

                    {{-- Detail rekening transfer (muncul saat transfer dipilih) --}}
                    <div class="co-transfer-detail" id="transferDetail">
                        <div class="co-transfer-bank">
                            <span class="co-transfer-bank-name">BCA</span>
                            <span class="co-transfer-bank-num">
                                1234567890
                                <button type="button" class="co-copy-btn" data-num="1234567890">Salin</button>
                            </span>
                        </div>
                        <div class="co-transfer-bank">
                            <span class="co-transfer-bank-name">Mandiri</span>
                            <span class="co-transfer-bank-num">
                                0987654321
                                <button type="button" class="co-copy-btn" data-num="0987654321">Salin</button>
                            </span>
                        </div>
                        <div class="co-transfer-bank">
                            <span class="co-transfer-bank-name">BRI</span>
                            <span class="co-transfer-bank-num">
                                1122334455
                                <button type="button" class="co-copy-btn" data-num="1122334455">Salin</button>
                            </span>
                        </div>
                        <div class="co-transfer-note">
                            <svg width="13" height="13" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"
                                style="flex-shrink:0;margin-top:1px">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 16v-4M12 8h.01" />
                            </svg>
                            Transfer sesuai nominal total. Pesanan diproses setelah pembayaran dikonfirmasi admin (maks.
                            1×24 jam).
                        </div>
                    </div>

                </div>

                {{-- ── 3. Daftar Produk ── --}}
                <div class="co-card">
                    <div class="co-section-label">
                        <div class="co-section-label__icon co-section-label__icon--gray">
                            <svg width="14" height="14" fill="none" stroke="#4A4A4A" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path d="M9 22V12h6v10" />
                            </svg>
                        </div>
                        <span class="co-section-label__text">Daftar Produk</span>
                        <span
                            style="margin-left:auto;font-size:11px;color:var(--co-ink3);font-family:'DM Mono',monospace">
                            {{ $order->items->count() }} item
                        </span>
                    </div>

                    <div class="co-product-list">
                        @foreach ($order->items as $item)
                            <div class="co-product-item">
                                @if ($item->product->image)
                                    <img src="{{ asset('assets/icons/' . $item->product->image) }}"
                                        alt="{{ $item->product->name }}" class="co-product-img">
                                @else
                                    <div class="co-product-img-placeholder">
                                        <svg width="22" height="22" fill="none" stroke="#CCCCCC"
                                            stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div style="flex:1;min-width:0">
                                    <p class="co-product-name">{{ $item->product->name }}</p>
                                    <p class="co-product-qty">× {{ $item->quantity }}</p>
                                    <div class="co-product-price-row">
                                        <span class="co-product-unit">
                                            Rp{{ number_format($item->product->price, 0, ',', '.') }} / pcs
                                        </span>
                                        <span class="co-product-subtotal">
                                            Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ── 4. Ringkasan Biaya ── --}}
                <div class="co-card">
                    <div class="co-section-label">
                        <div class="co-section-label__icon co-section-label__icon--green">
                            <svg width="14" height="14" fill="none" stroke="#1A7A4A" stroke-width="2"
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
                            <span class="co-summary-val">
                                Rp{{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="co-summary-row">
                            <span class="co-summary-label">Ongkos kirim</span>
                            <span class="co-shipping-free">
                                <svg width="12" height="12" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                    viewBox="0 0 24 24">
                                    <path d="M20 6L9 17l-5-5" />
                                </svg>
                                Gratis
                            </span>
                        </div>
                        <div class="co-summary-divider"></div>
                        <div class="co-summary-row">
                            <span class="co-summary-total-label">Total pembayaran</span>
                            <span class="co-summary-total-val">
                                Rp{{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <div class="co-info">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 16v-4M12 8h.01" />
                        </svg>
                        Pembayaran dilakukan setelah pesanan dikonfirmasi kurir
                    </div>
                </div>

            </div>
        </div>
        @if (session('success'))
            <div class="mb-3 text-green-600 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Footer sticky --}}
        <div class="co-footer">
            <div>
                <p class="co-footer__total-label">Total pembayaran</p>
                <p class="co-footer__total-val">
                    Rp{{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}
                </p>
            </div>
            <button type="submit" class="co-footer__btn">
                Buat Pesanan →
            </button>
        </div>

    </form>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // ── Tampilkan/sembunyikan detail transfer ──────────────────
            const payRadios = document.querySelectorAll('input[name="payment_method"]');
            const transferDetail = document.getElementById('transferDetail');

            function toggleTransfer() {
                const selected = document.querySelector('input[name="payment_method"]:checked');
                if (selected && selected.value === 'transfer') {
                    transferDetail.classList.add('visible');
                } else {
                    transferDetail.classList.remove('visible');
                }
            }

            payRadios.forEach(r => r.addEventListener('change', toggleTransfer));
            toggleTransfer(); // init

            // ── Tombol salin nomor rekening ────────────────────────────
            document.querySelectorAll('.co-copy-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const num = btn.dataset.num;
                    navigator.clipboard.writeText(num).then(() => {
                        btn.textContent = '✓ Tersalin';
                        btn.classList.add('copied');
                        setTimeout(() => {
                            btn.textContent = 'Salin';
                            btn.classList.remove('copied');
                        }, 2000);
                    });
                });
            });

        });
    </script>

</x-app-layout>
