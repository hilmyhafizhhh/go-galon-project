<x-app-layout>
    <form action="{{ route('customer.checkout.process') }}" method="POST" id="checkoutForm">
        @csrf

        <div class="co-root">

            {{-- ── Header ── --}}
            <div class="co-header">
                <a href="javascript:history.back()" class="co-header__back" aria-label="Kembali">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                </a>
                <span class="co-header__title">Checkout</span>
                <div style="width:36px"></div>
            </div>

            {{-- ── Progress ── --}}
            <div class="co-progress-wrap">
                <div class="co-progress">
                    <div class="co-progress__step co-progress__step--done">
                        <div class="co-progress__dot">
                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>
                        </div>
                        <span>Keranjang</span>
                    </div>
                    <div class="co-progress__line co-progress__line--done"></div>
                    <div class="co-progress__step co-progress__step--active">
                        <div class="co-progress__dot">
                            <div class="co-progress__pulse"></div>
                        </div>
                        <span>Checkout</span>
                    </div>
                    <div class="co-progress__line"></div>
                    <div class="co-progress__step">
                        <div class="co-progress__dot"></div>
                        <span>Selesai</span>
                    </div>
                </div>
            </div>

            <div class="co-body">

                {{-- ── Hidden selected address id ── --}}
                @php
                    $selectedAddress = $addresses->firstWhere('is_default', true) ?? $addresses->first();
                @endphp
                <input type="hidden" name="address_id" id="selectedAddressId"
                    value="{{ $selectedAddress?->id }}">

                {{-- ── 1. Alamat Pengiriman ── --}}
                <div class="co-section-title">
                    <span class="co-section-title__num">1</span>
                    <span>Alamat Pengiriman</span>
                </div>

                {{-- Single address card — tap to go to address selector page --}}
                <a href="{{ route('customer.address.select') }}" class="co-addr-card" id="addrCardLink">
                    @if ($selectedAddress)
                        <div class="co-addr-card__icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="co-addr-card__body">
                            <div class="co-addr-card__top">
                                <span class="co-addr-card__label">{{ $selectedAddress->label }}</span>
                                @if ($selectedAddress->is_default)
                                    <span class="co-chip co-chip--primary">Utama</span>
                                @endif
                            </div>
                            <p class="co-addr-card__address">{{ $selectedAddress->address }}</p>
                        </div>
                    @else
                        <div class="co-addr-card__icon co-addr-card__icon--empty">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </div>
                        <div class="co-addr-card__body">
                            <p class="co-addr-card__empty">Tambah alamat pengiriman</p>
                        </div>
                    @endif
                    <div class="co-addr-card__arrow">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2"
                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M9 18l6-6-6-6" />
                        </svg>
                    </div>
                </a>

                {{-- ── 2. Metode Pembayaran ── --}}
                <div class="co-section-title">
                    <span class="co-section-title__num">2</span>
                    <span>Metode Pembayaran</span>
                </div>

                <div class="co-card">
                    <label class="co-pay-row {{ request()->old('payment_method', 'cod') === 'cod' ? 'co-pay-row--active' : '' }}" id="payRowCod">
                        <input type="radio" name="payment_method" value="cod" id="pay_cod"
                            {{ request()->old('payment_method', 'cod') === 'cod' ? 'checked' : '' }}>
                        <div class="co-pay-row__icon co-pay-row__icon--cod">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2" />
                                <rect x="9" y="11" width="12" height="8" rx="2" />
                                <circle cx="15" cy="15" r="1.5" />
                            </svg>
                        </div>
                        <div class="co-pay-row__info">
                            <span class="co-pay-row__name">Bayar di Tempat <em>(COD)</em></span>
                            <span class="co-pay-row__desc">Bayar tunai saat barang tiba</span>
                        </div>
                        <span class="co-chip co-chip--green">Populer</span>
                        <div class="co-radio-visual"><div class="co-radio-dot"></div></div>
                    </label>

                    <div class="co-pay-divider"></div>

                    <label class="co-pay-row" id="payRowTransfer">
                        <input type="radio" name="payment_method" value="transfer" id="pay_transfer">
                        <div class="co-pay-row__icon co-pay-row__icon--transfer">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <rect x="2" y="5" width="20" height="14" rx="2" />
                                <path d="M2 10h20M6 15h4" />
                            </svg>
                        </div>
                        <div class="co-pay-row__info">
                            <span class="co-pay-row__name">Transfer Bank</span>
                            <span class="co-pay-row__desc">BCA · Mandiri · BRI</span>
                        </div>
                        <span class="co-chip co-chip--gray">Manual</span>
                        <div class="co-radio-visual"><div class="co-radio-dot"></div></div>
                    </label>

                    {{-- Transfer detail --}}
                    <div class="co-transfer-panel" id="transferDetail">
                        <div class="co-transfer-panel__inner">
                            <p class="co-transfer-panel__title">Rekening Tujuan</p>
                            @foreach ([['BCA', '1234567890'], ['Mandiri', '0987654321'], ['BRI', '1122334455']] as [$bank, $num])
                                <div class="co-bank-row">
                                    <div class="co-bank-row__left">
                                        <span class="co-bank-row__logo">{{ $bank }}</span>
                                        <span class="co-bank-row__num">{{ $num }}</span>
                                    </div>
                                    <button type="button" class="co-copy-btn" data-num="{{ $num }}">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                            <rect x="9" y="9" width="13" height="13" rx="2" />
                                            <path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1" />
                                        </svg>
                                        Salin
                                    </button>
                                </div>
                            @endforeach
                            <p class="co-transfer-panel__note">
                                Transfer sesuai nominal total. Pesanan diproses setelah dikonfirmasi admin (maks. 1×24 jam).
                            </p>
                        </div>
                    </div>
                </div>

                {{-- ── 3. Daftar Produk ── --}}
                <div class="co-section-title">
                    <span class="co-section-title__num">3</span>
                    <span>Daftar Produk</span>
                    <span class="co-section-title__count">{{ $order->items->count() }} item</span>
                </div>

                <div class="co-card">
                    @foreach ($order->items as $item)
                        <div class="co-prod-row {{ !$loop->last ? 'co-prod-row--border' : '' }}">
                            <div class="co-prod-img">
                                @if ($item->product->image)
                                    <img src="{{ asset('assets/icons/' . $item->product->image) }}"
                                        alt="{{ $item->product->name }}">
                                @else
                                    <div class="co-prod-img__placeholder">
                                        <svg width="18" height="18" fill="none" stroke="#C8C8C8" stroke-width="1.5"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="co-prod-info">
                                <p class="co-prod-name">{{ $item->product->name }}</p>
                                <span class="co-prod-meta">{{ $item->quantity }} pcs
                                    &nbsp;·&nbsp; Rp{{ number_format($item->product->price, 0, ',', '.') }}/pcs</span>
                            </div>
                            <span class="co-prod-sub">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                {{-- ── 4. Ringkasan Biaya ── --}}
                <div class="co-section-title">
                    <span class="co-section-title__num">4</span>
                    <span>Ringkasan Biaya</span>
                </div>

                <div class="co-card co-summary-card">
                    <div class="co-sum-row">
                        <span class="co-sum-label">Subtotal produk</span>
                        <span class="co-sum-val">Rp{{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}</span>
                    </div>
                    <div class="co-sum-row">
                        <span class="co-sum-label">Ongkos kirim</span>
                        <span class="co-sum-free">
                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>
                            Gratis
                        </span>
                    </div>
                    <div class="co-sum-divider"></div>
                    <div class="co-sum-row co-sum-row--total">
                        <span>Total pembayaran</span>
                        <span class="co-sum-total">Rp{{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}</span>
                    </div>
                    <div class="co-sum-note">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px">
                            <circle cx="12" cy="12" r="10" /><path d="M12 16v-4M12 8h.01" />
                        </svg>
                        Pembayaran dilakukan setelah pesanan dikonfirmasi kurir
                    </div>
                </div>

                @if (session('success'))
                    <div class="co-alert">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M20 6L9 17l-5-5" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                <div style="height: 110px"></div>

            </div>
        </div>

        {{-- ── Sticky Footer ── --}}
        <div class="co-footer">
            <div class="co-footer__inner">
                <div class="co-footer__info">
                    <span class="co-footer__label">Total pembayaran</span>
                    <span class="co-footer__val">Rp{{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}</span>
                </div>
                <button type="submit" class="co-footer__btn" id="submitBtn">
                    Buat Pesanan
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

    </form>

    {{-- ── Styles ── --}}
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg: #F4F6FA;
            --surface: #FFFFFF;
            --border: #E8ECF2;
            --border-mid: #D8DFE9;
            --text-primary: #0D1117;
            --text-secondary: #5A6478;
            --text-muted: #9AA3B2;
            --accent: #2563EB;
            --accent-soft: #EEF4FF;
            --accent-mid: #DBEAFE;
            --green: #16A34A;
            --green-soft: #ECFDF5;
            --amber-soft: #FFFBEB;
            --amber: #D97706;
            --radius-card: 16px;
            --radius-sm: 10px;
            --shadow-card: 0 1px 4px rgba(15,30,60,.06), 0 1px 2px rgba(15,30,60,.04);
            --shadow-footer: 0 -4px 28px rgba(15,30,60,.10);
        }

        body { background: var(--bg); font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Text', 'Segoe UI', sans-serif; color: var(--text-primary); }

        /* ── Header ── */
        .co-root { min-height: 100dvh; }
        .co-header {
            position: sticky; top: 0; z-index: 50;
            display: flex; align-items: center; justify-content: space-between;
            padding: 14px 16px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(12px);
        }
        .co-header__back {
            width: 36px; height: 36px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 50%; background: var(--bg);
            color: var(--text-primary); text-decoration: none;
            transition: background .15s;
        }
        .co-header__back:active { background: var(--border); }
        .co-header__title { font-size: 16px; font-weight: 700; color: var(--text-primary); letter-spacing: -.3px; }

        /* ── Progress ── */
        .co-progress-wrap { background: var(--surface); padding: 16px 20px 18px; border-bottom: 1px solid var(--border); }
        .co-progress { display: flex; align-items: center; gap: 0; }
        .co-progress__step { display: flex; flex-direction: column; align-items: center; gap: 5px; flex-shrink: 0; }
        .co-progress__step span { font-size: 10px; font-weight: 500; color: var(--text-muted); letter-spacing: .2px; }
        .co-progress__step--done span,
        .co-progress__step--active span { color: var(--text-primary); font-weight: 600; }
        .co-progress__dot {
            width: 24px; height: 24px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            background: var(--bg); border: 2px solid var(--border-mid);
            color: var(--text-muted); position: relative;
        }
        .co-progress__step--done .co-progress__dot { background: var(--accent); border-color: var(--accent); color: white; }
        .co-progress__step--active .co-progress__dot { background: var(--accent); border-color: var(--accent); }
        .co-progress__pulse {
            width: 8px; height: 8px; border-radius: 50%; background: white;
            animation: pulse 1.6s ease-in-out infinite;
        }
        @keyframes pulse { 0%,100%{transform:scale(1);opacity:1} 50%{transform:scale(1.3);opacity:.7} }
        .co-progress__line { flex: 1; height: 2px; background: var(--border); margin: 0 4px; margin-bottom: 16px; }
        .co-progress__line--done { background: var(--accent); }

        /* ── Body ── */
        .co-body { padding: 18px 16px 0; display: flex; flex-direction: column; gap: 8px; }

        /* ── Section title ── */
        .co-section-title {
            display: flex; align-items: center; gap: 8px;
            font-size: 12px; font-weight: 600; color: var(--text-secondary);
            letter-spacing: .4px; text-transform: uppercase; padding: 4px 2px 2px;
        }
        .co-section-title__num {
            width: 20px; height: 20px; border-radius: 50%;
            background: var(--accent); color: white;
            font-size: 10px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .co-section-title__count { margin-left: auto; font-size: 11px; font-weight: 500; color: var(--text-muted); }

        /* ── Card ── */
        .co-card {
            background: var(--surface);
            border-radius: var(--radius-card);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }

        /* ── Address card ── */
        .co-addr-card {
            display: flex; align-items: center; gap: 13px;
            background: var(--surface);
            border-radius: var(--radius-card);
            border: 1.5px solid var(--border);
            box-shadow: var(--shadow-card);
            padding: 15px 16px;
            text-decoration: none; color: inherit;
            transition: border-color .18s, box-shadow .18s, background .12s;
            position: relative;
        }
        .co-addr-card::after {
            content: '';
            position: absolute; inset: 0; border-radius: var(--radius-card);
            background: var(--accent); opacity: 0;
            transition: opacity .12s;
            pointer-events: none;
        }
        .co-addr-card:active::after { opacity: .03; }
        .co-addr-card:active { border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-soft); }
        .co-addr-card__icon {
            width: 38px; height: 38px; flex-shrink: 0; border-radius: 11px;
            background: var(--accent-soft); color: var(--accent);
            display: flex; align-items: center; justify-content: center;
        }
        .co-addr-card__icon--empty { background: var(--bg); color: var(--text-muted); }
        .co-addr-card__body { flex: 1; min-width: 0; }
        .co-addr-card__top { display: flex; align-items: center; gap: 6px; margin-bottom: 3px; }
        .co-addr-card__label { font-size: 14px; font-weight: 700; color: var(--text-primary); }
        .co-addr-card__address {
            font-size: 12.5px; color: var(--text-secondary); line-height: 1.45;
            overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
        }
        .co-addr-card__empty { font-size: 14px; color: var(--text-muted); }
        .co-addr-card__arrow { color: var(--text-muted); flex-shrink: 0; }

        /* ── Chips ── */
        .co-chip { display: inline-flex; align-items: center; padding: 2px 7px; border-radius: 20px;
            font-size: 10px; font-weight: 700; letter-spacing: .3px; flex-shrink: 0; }
        .co-chip--primary { background: var(--accent-soft); color: var(--accent); }
        .co-chip--green { background: var(--green-soft); color: var(--green); }
        .co-chip--gray { background: var(--bg); color: var(--text-secondary); border: 1px solid var(--border-mid); }

        /* ── Payment rows ── */
        .co-pay-row {
            display: flex; align-items: center; gap: 11px;
            padding: 14px 16px; cursor: pointer;
            transition: background .12s;
        }
        .co-pay-row:active { background: var(--bg); }
        .co-pay-row input[type="radio"] { display: none; }
        .co-pay-row__icon {
            width: 38px; height: 38px; border-radius: 11px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
        }
        .co-pay-row__icon--cod { background: var(--amber-soft); color: var(--amber); }
        .co-pay-row__icon--transfer { background: var(--accent-soft); color: var(--accent); }
        .co-pay-row__info { flex: 1; min-width: 0; }
        .co-pay-row__name { display: block; font-size: 13.5px; font-weight: 600; color: var(--text-primary); }
        .co-pay-row__name em { font-style: normal; font-weight: 500; color: var(--text-secondary); }
        .co-pay-row__desc { font-size: 11.5px; color: var(--text-muted); margin-top: 1px; display: block; }
        .co-radio-visual {
            width: 20px; height: 20px; border-radius: 50%; flex-shrink: 0;
            border: 2px solid var(--border-mid);
            display: flex; align-items: center; justify-content: center;
            transition: border-color .15s;
        }
        .co-radio-dot { width: 8px; height: 8px; border-radius: 50%; background: transparent; transition: background .15s; }
        .co-pay-row--active .co-radio-visual { border-color: var(--accent); }
        .co-pay-row--active .co-radio-dot { background: var(--accent); }
        .co-pay-divider { height: 1px; background: var(--border); margin: 0 16px; }

        /* ── Transfer panel ── */
        .co-transfer-panel { max-height: 0; overflow: hidden; transition: max-height .3s cubic-bezier(.4,0,.2,1); }
        .co-transfer-panel.open { max-height: 300px; }
        .co-transfer-panel__inner {
            margin: 0 16px 14px; padding: 14px;
            background: var(--bg); border-radius: 10px; border: 1px solid var(--border);
        }
        .co-transfer-panel__title { font-size: 10.5px; font-weight: 700; color: var(--text-secondary);
            text-transform: uppercase; letter-spacing: .7px; margin-bottom: 10px; }
        .co-bank-row { display: flex; align-items: center; justify-content: space-between; padding: 8px 0;
            border-bottom: 1px solid var(--border); }
        .co-bank-row:last-of-type { border-bottom: none; }
        .co-bank-row__left { display: flex; align-items: center; gap: 10px; }
        .co-bank-row__logo { font-size: 11px; font-weight: 800; color: var(--text-primary); letter-spacing: .3px; }
        .co-bank-row__num { font-size: 13px; font-weight: 500; color: var(--text-primary); font-variant-numeric: tabular-nums; }
        .co-copy-btn {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 11.5px; font-weight: 600; color: var(--accent);
            background: var(--accent-soft); border: none; border-radius: 6px;
            padding: 5px 9px; cursor: pointer; transition: opacity .15s;
        }
        .co-copy-btn.copied { color: var(--green); background: var(--green-soft); }
        .co-transfer-panel__note { font-size: 11.5px; color: var(--text-muted); line-height: 1.5; margin-top: 10px; }

        /* ── Products ── */
        .co-prod-row { display: flex; align-items: center; gap: 12px; padding: 13px 16px; }
        .co-prod-row--border { border-bottom: 1px solid var(--border); }
        .co-prod-img { width: 52px; height: 52px; border-radius: 11px; flex-shrink: 0; overflow: hidden;
            background: var(--bg); border: 1px solid var(--border); }
        .co-prod-img img { width: 100%; height: 100%; object-fit: cover; }
        .co-prod-img__placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; }
        .co-prod-info { flex: 1; min-width: 0; }
        .co-prod-name { font-size: 13px; font-weight: 600; color: var(--text-primary); line-height: 1.4;
            overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
        .co-prod-meta { font-size: 11.5px; color: var(--text-muted); margin-top: 3px; display: block; }
        .co-prod-sub { font-size: 13.5px; font-weight: 700; color: var(--text-primary); flex-shrink: 0; font-variant-numeric: tabular-nums; }

        /* ── Summary ── */
        .co-summary-card { padding: 16px; }
        .co-sum-row { display: flex; align-items: center; justify-content: space-between;
            font-size: 13.5px; color: var(--text-secondary); margin-bottom: 10px; }
        .co-sum-label { color: var(--text-secondary); }
        .co-sum-val { font-weight: 600; color: var(--text-primary); font-variant-numeric: tabular-nums; }
        .co-sum-free { display: inline-flex; align-items: center; gap: 4px; font-weight: 700; color: var(--green); font-size: 12.5px; }
        .co-sum-divider { height: 1px; background: var(--border); margin: 4px 0 14px; }
        .co-sum-row--total { font-size: 15px; font-weight: 700; color: var(--text-primary); margin-bottom: 12px; }
        .co-sum-total { color: var(--accent); font-size: 17px; font-variant-numeric: tabular-nums; }
        .co-sum-note { display: flex; align-items: flex-start; gap: 6px;
            font-size: 11.5px; color: var(--text-muted); line-height: 1.5;
            padding: 10px 12px; background: var(--bg); border-radius: 8px; border: 1px solid var(--border); }

        /* ── Alert ── */
        .co-alert {
            display: flex; align-items: center; gap: 8px;
            background: var(--green-soft); border: 1px solid #BBF7D0; border-radius: 10px;
            padding: 12px 14px; font-size: 13px; font-weight: 500; color: var(--green); margin-top: 4px;
        }

        /* ── Footer ── */
        .co-footer {
            position: fixed; bottom: 0; left: 0; right: 0; z-index: 50;
            background: var(--surface);
            border-top: 1px solid var(--border);
            box-shadow: var(--shadow-footer);
            padding: 12px 16px;
            padding-bottom: calc(12px + env(safe-area-inset-bottom));
        }
        .co-footer__inner { display: flex; align-items: center; gap: 12px; }
        .co-footer__info { flex: 1; min-width: 0; }
        .co-footer__label { font-size: 11px; color: var(--text-muted); display: block; font-weight: 500; }
        .co-footer__val { font-size: 18px; font-weight: 800; color: var(--text-primary); font-variant-numeric: tabular-nums; letter-spacing: -.4px; }
        .co-footer__btn {
            display: inline-flex; align-items: center; gap: 7px;
            background: var(--accent); color: white;
            font-size: 14px; font-weight: 700; letter-spacing: -.2px;
            border: none; border-radius: 13px; padding: 14px 22px;
            cursor: pointer; white-space: nowrap; flex-shrink: 0;
            box-shadow: 0 4px 16px rgba(37,99,235,.32);
            transition: opacity .15s, transform .1s;
        }
        .co-footer__btn:active { opacity: .9; transform: scale(.98); }
        .co-footer__btn:disabled { opacity: .6; pointer-events: none; }

        @keyframes spin { to { transform: rotate(360deg); } }
        .co-spin { animation: spin .8s linear infinite; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // ── Payment toggle ──
            const payRadios = document.querySelectorAll('input[name="payment_method"]');
            const transferDetail = document.getElementById('transferDetail');
            const payRows = { cod: document.getElementById('payRowCod'), transfer: document.getElementById('payRowTransfer') };

            function syncPayment() {
                const val = document.querySelector('input[name="payment_method"]:checked')?.value;
                transferDetail.classList.toggle('open', val === 'transfer');
                payRows.cod.classList.toggle('co-pay-row--active', val === 'cod');
                payRows.transfer.classList.toggle('co-pay-row--active', val === 'transfer');
            }

            payRadios.forEach(r => r.addEventListener('change', syncPayment));
            syncPayment();

            // ── Copy buttons ──
            document.querySelectorAll('.co-copy-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    navigator.clipboard.writeText(btn.dataset.num).then(() => {
                        const orig = btn.innerHTML;
                        btn.innerHTML = `<svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg> Tersalin`;
                        btn.classList.add('copied');
                        setTimeout(() => { btn.innerHTML = orig; btn.classList.remove('copied'); }, 2000);
                    });
                });
            });

            // ── Submit loading ──
            document.getElementById('checkoutForm').addEventListener('submit', function () {
                const btn = document.getElementById('submitBtn');
                btn.disabled = true;
                btn.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" class="co-spin"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg> Memproses...`;
            });

            // ── Restore selected address from session ──
            const pendingAddr = sessionStorage.getItem('selected_address_id');
            if (pendingAddr) {
                document.getElementById('selectedAddressId').value = pendingAddr;
                sessionStorage.removeItem('selected_address_id');
            }
        });
    </script>
</x-app-layout>