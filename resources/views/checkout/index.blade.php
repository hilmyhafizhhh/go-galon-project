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
                    $defaultAddress  = $selectedAddress;
                @endphp
                <input type="hidden" name="address_id" id="selectedAddressId" value="{{ $selectedAddress?->id }}">

                {{-- ── 1. Alamat Pengiriman ── --}}
                <div class="co-section-title">
                    <span class="co-section-title__num">1</span>
                    <span>Alamat Pengiriman</span>
                </div>

                {{-- Hidden radio inputs — bawa data-* agar JS bisa update tampilan --}}
                @foreach ($addresses as $address)
                    <input type="radio" name="address_id" id="addr_{{ $address->id }}" value="{{ $address->id }}"
                        data-label="{{ $address->label }}" data-address="{{ $address->address }}"
                        data-is-default="{{ $address->is_default ? '1' : '0' }}"
                        {{ $address->id == $defaultAddress?->id ? 'checked' : '' }}
                        style="display:none">
                @endforeach

                @if ($defaultAddress)
                    <a href="{{ route('customer.checkout.address-picker') }}" class="co-addr-card" id="addrCardLink">
                        <div class="co-addr-card__icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="co-addr-card__body">
                            <div class="co-addr-card__top">
                                <span class="co-addr-card__label" id="addrLabel">{{ $defaultAddress->label }}</span>
                                <span class="co-badge co-badge--blue co-addr-row__badge" id="addrBadge"
                                    style="{{ $defaultAddress->is_default ? '' : 'display:none' }}">Utama</span>
                            </div>
                            <p class="co-addr-card__address" id="addrDetail">{{ $defaultAddress->address }}</p>
                        </div>
                        <div class="co-addr-card__arrow">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M9 18l6-6-6-6" />
                            </svg>
                        </div>
                    </a>
                @else
                    <a href="{{ route('customer.address.create') }}" class="co-addr-card">
                        <div class="co-addr-card__icon co-addr-card__icon--empty">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </div>
                        <div class="co-addr-card__body">
                            <p class="co-addr-card__empty">Tambah alamat pengiriman</p>
                        </div>
                        <div class="co-addr-card__arrow">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M9 18l6-6-6-6" />
                            </svg>
                        </div>
                    </a>
                @endif

                {{-- ── 2. Metode Pembayaran ── --}}
                <div class="co-section-title">
                    <span class="co-section-title__num">2</span>
                    <span>Metode Pembayaran</span>
                </div>

                <div class="co-card">
                    <label class="co-pay-row co-pay-row--active" id="payRowCod">
                        <input type="radio" name="payment_method" value="cod" id="pay_cod" checked>
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
                        <div class="co-radio-visual">
                            <div class="co-radio-dot"></div>
                        </div>
                    </label>

                    <div class="co-pay-divider"></div>

                    <label class="co-pay-row" id="payRowMidtrans">
                        <input type="radio" name="payment_method" value="midtrans" id="pay_midtrans">
                        <div class="co-pay-row__icon co-pay-row__icon--transfer">
                            <svg width="18" height="18" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                viewBox="0 0 24 24">
                                <rect x="2" y="5" width="20" height="14" rx="2" />
                                <path d="M2 10h20M6 15h4" />
                            </svg>
                        </div>
                        <div class="co-pay-row__info">
                            <span class="co-pay-row__name">Bayar Online</span>
                            <span class="co-pay-row__desc">Transfer Bank · QRIS · GoPay · OVO</span>
                        </div>
                        <span class="co-chip co-chip--primary">Midtrans</span>
                        <div class="co-radio-visual">
                            <div class="co-radio-dot"></div>
                        </div>
                    </label>
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
                                        <svg width="18" height="18" fill="none" stroke="#C8C8C8"
                                            stroke-width="1.5" viewBox="0 0 24 24">
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

                    {{-- ── Add Note trigger ── --}}
                    <button type="button" class="co-note-trigger" id="openNoteSheet">
                        <div class="co-note-trigger__left">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
                                <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                            <span id="noteTriggerText">Tambah catatan untuk kurir</span>
                        </div>
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2"
                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M9 18l6-6-6-6" />
                        </svg>
                    </button>

                    {{-- hidden input yang dikirim ke form --}}
                    <input type="hidden" name="note" id="noteHidden">
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
                            <svg width="11" height="11" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                viewBox="0 0 24 24">
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
                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"
                            style="flex-shrink:0;margin-top:1px">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 16v-4M12 8h.01" />
                        </svg>
                        Pembayaran dilakukan setelah pesanan dikonfirmasi kurir
                    </div>
                </div>

                <x-flash-toast />
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

    {{-- ── Note Bottom Sheet ── --}}
    <div class="ef-sheet-overlay" id="noteSheet" role="dialog" aria-modal="true" aria-labelledby="noteSheetTitle">
        <div class="ef-sheet" id="noteSheetBox">
            <div class="ef-sheet__pill"></div>

            <div style="display:flex;align-items:center;justify-content:space-between;padding:0 0 16px">
                <h3 class="ef-sheet__title" id="noteSheetTitle" style="text-align:left;margin:0;font-size:.95rem">
                    Catatan untuk Kurir
                </h3>
                <button id="closeNoteSheet"
                    style="width:30px;height:30px;border-radius:8px;background:#f1f5f9;border:none;display:flex;align-items:center;justify-content:center;cursor:pointer;color:#64748b">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M18 6L6 18M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Quick chips --}}
            <div class="co-note-chips">
                <button type="button" class="co-note-chip" data-note="Hubungi saya sebelum datang">
                    📞 Hubungi dulu
                </button>
                <button type="button" class="co-note-chip" data-note="Taruh di depan pintu, saya tidak ada di rumah">
                    🚪 Taruh di depan pintu
                </button>
                <button type="button" class="co-note-chip" data-note="Galon kosong ada di depan, tolong dibawa balik">
                    🔄 Bawa galon kosong
                </button>
                <button type="button" class="co-note-chip" data-note="Tidak ada lift, tolong naik tangga">
                    🏢 Tidak ada lift
                </button>
            </div>

            {{-- Textarea --}}
            <div style="position:relative;margin-top:12px">
                <textarea id="noteTextarea" rows="3" maxlength="200"
                    placeholder="Contoh: Hubungi 10 menit sebelum tiba, galon kosong di depan pagar..."
                    class="co-note-textarea"></textarea>
                <span class="co-note-counter"><span id="noteCount">0</span>/200</span>
            </div>

            <div class="ef-sheet__actions" style="margin-top:16px">
                <button class="ef-sheet__btn-del" id="saveNote"
                    style="background:linear-gradient(135deg,#2563eb,#1d4ed8);box-shadow:0 4px 14px rgba(37,99,235,.35)">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M20 6L9 17l-5-5" />
                    </svg>
                    Simpan Catatan
                </button>
                <button class="ef-sheet__btn-cancel" id="clearNote">Hapus Catatan</button>
            </div>
        </div>
    </div>

    {{-- ── Styles ── --}}
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

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
            --shadow-card: 0 1px 4px rgba(15, 30, 60, .06), 0 1px 2px rgba(15, 30, 60, .04);
            --shadow-footer: 0 -4px 28px rgba(15, 30, 60, .10);
        }

        body {
            background: var(--bg);
            font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Text', 'Segoe UI', sans-serif;
            color: var(--text-primary);
        }

        .co-root { min-height: 100dvh; }

        /* ── Header ── */
        .co-header {
            position: sticky;
            top: 0;
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 16px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(12px);
        }

        .co-header__back {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: var(--bg);
            color: var(--text-primary);
            text-decoration: none;
            transition: background .15s;
        }

        .co-header__back:active { background: var(--border); }

        .co-header__title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -.3px;
        }

        /* ── Progress ── */
        .co-progress-wrap {
            background: var(--surface);
            padding: 16px 20px 18px;
            border-bottom: 1px solid var(--border);
        }

        .co-progress {
            display: flex;
            align-items: center;
            gap: 0;
        }

        .co-progress__step {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
            flex-shrink: 0;
        }

        .co-progress__step span {
            font-size: 10px;
            font-weight: 500;
            color: var(--text-muted);
            letter-spacing: .2px;
        }

        .co-progress__step--done span,
        .co-progress__step--active span {
            color: var(--text-primary);
            font-weight: 600;
        }

        .co-progress__dot {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg);
            border: 2px solid var(--border-mid);
            color: var(--text-muted);
            position: relative;
        }

        .co-progress__step--done .co-progress__dot {
            background: var(--accent);
            border-color: var(--accent);
            color: white;
        }

        .co-progress__step--active .co-progress__dot {
            background: var(--accent);
            border-color: var(--accent);
        }

        .co-progress__pulse {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: white;
            animation: pulse 1.6s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1 }
            50%       { transform: scale(1.3); opacity: .7 }
        }

        .co-progress__line {
            flex: 1;
            height: 2px;
            background: var(--border);
            margin: 0 4px;
            margin-bottom: 16px;
        }

        .co-progress__line--done { background: var(--accent); }

        /* ── Body ── */
        .co-body {
            padding: 18px 16px 0;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        /* ── Section title ── */
        .co-section-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            letter-spacing: .4px;
            text-transform: uppercase;
            padding: 4px 2px 2px;
        }

        .co-section-title__num {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--accent);
            color: white;
            font-size: 10px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .co-section-title__count {
            margin-left: auto;
            font-size: 11px;
            font-weight: 500;
            color: var(--text-muted);
        }

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
            display: flex;
            align-items: center;
            gap: 13px;
            background: var(--surface);
            border-radius: var(--radius-card);
            border: 1.5px solid var(--border);
            box-shadow: var(--shadow-card);
            padding: 15px 16px;
            text-decoration: none;
            color: inherit;
            transition: border-color .18s, box-shadow .18s, background .12s;
            position: relative;
        }

        .co-addr-card::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: var(--radius-card);
            background: var(--accent);
            opacity: 0;
            transition: opacity .12s;
            pointer-events: none;
        }

        .co-addr-card:active::after { opacity: .03; }

        .co-addr-card:active {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-soft);
        }

        .co-addr-card__icon {
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            border-radius: 11px;
            background: var(--accent-soft);
            color: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .co-addr-card__icon--empty {
            background: var(--bg);
            color: var(--text-muted);
        }

        .co-addr-card__body {
            flex: 1;
            min-width: 0;
        }

        .co-addr-card__top {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 3px;
        }

        .co-addr-card__label {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .co-addr-card__address {
            font-size: 12.5px;
            color: var(--text-secondary);
            line-height: 1.45;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .co-addr-card__empty {
            font-size: 14px;
            color: var(--text-muted);
        }

        .co-addr-card__arrow {
            color: var(--text-muted);
            flex-shrink: 0;
        }

        /* ── Chips ── */
        .co-chip {
            display: inline-flex;
            align-items: center;
            padding: 2px 7px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .3px;
            flex-shrink: 0;
        }

        .co-chip--primary { background: var(--accent-soft); color: var(--accent); }
        .co-chip--green   { background: var(--green-soft);  color: var(--green); }
        .co-chip--gray    { background: var(--bg); color: var(--text-secondary); border: 1px solid var(--border-mid); }

        /* ── Payment rows ── */
        .co-pay-row {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 14px 16px;
            cursor: pointer;
            transition: background .12s;
        }

        .co-pay-row:active { background: var(--bg); }
        .co-pay-row input[type="radio"] { display: none; }

        .co-pay-row__icon {
            width: 38px;
            height: 38px;
            border-radius: 11px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .co-pay-row__icon--cod      { background: var(--amber-soft); color: var(--amber); }
        .co-pay-row__icon--transfer { background: var(--accent-soft); color: var(--accent); }

        .co-pay-row__info { flex: 1; min-width: 0; }

        .co-pay-row__name {
            display: block;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .co-pay-row__name em {
            font-style: normal;
            font-weight: 500;
            color: var(--text-secondary);
        }

        .co-pay-row__desc {
            font-size: 11.5px;
            color: var(--text-muted);
            margin-top: 1px;
            display: block;
        }

        .co-radio-visual {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            flex-shrink: 0;
            border: 2px solid var(--border-mid);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: border-color .15s;
        }

        .co-radio-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: transparent;
            transition: background .15s;
        }

        .co-pay-row--active .co-radio-visual { border-color: var(--accent); }
        .co-pay-row--active .co-radio-dot    { background: var(--accent); }
        .co-pay-divider { height: 1px; background: var(--border); margin: 0 16px; }

        /* ── Note trigger ── */
        .co-note-trigger {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 13px 16px;
            border: none;
            border-top: 1px solid var(--border);
            background: transparent;
            cursor: pointer;
            color: var(--text-secondary);
            font-size: 13px;
            transition: background .12s;
        }

        .co-note-trigger:active { background: var(--bg); }

        .co-note-trigger__left {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .co-note-trigger.has-note { color: var(--accent); }

        /* ── Note chips ── */
        .co-note-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .co-note-chip {
            padding: 7px 12px;
            border-radius: 20px;
            border: 1.5px solid var(--border-mid);
            background: var(--bg);
            font-size: 12px;
            font-weight: 500;
            color: var(--text-secondary);
            cursor: pointer;
            transition: border-color .15s, background .15s, color .15s;
        }

        .co-note-chip.active,
        .co-note-chip:active {
            border-color: var(--accent);
            background: var(--accent-soft);
            color: var(--accent);
        }

        /* ── Note textarea ── */
        .co-note-textarea {
            width: 100%;
            border: 1.5px solid var(--border-mid);
            border-radius: 10px;
            padding: 12px 14px 28px;
            font-size: 13.5px;
            font-family: inherit;
            color: var(--text-primary);
            background: var(--bg);
            resize: none;
            outline: none;
            line-height: 1.55;
            transition: border-color .15s;
        }

        .co-note-textarea:focus { border-color: var(--accent); }

        .co-note-counter {
            position: absolute;
            bottom: 9px;
            right: 12px;
            font-size: 11px;
            color: var(--text-muted);
        }

        /* ── Products ── */
        .co-prod-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 16px;
        }

        .co-prod-row--border { border-bottom: 1px solid var(--border); }

        .co-prod-img {
            width: 52px;
            height: 52px;
            border-radius: 11px;
            flex-shrink: 0;
            overflow: hidden;
            background: var(--bg);
            border: 1px solid var(--border);
        }

        .co-prod-img img { width: 100%; height: 100%; object-fit: cover; }

        .co-prod-img__placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .co-prod-info { flex: 1; min-width: 0; }

        .co-prod-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            line-height: 1.4;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .co-prod-meta {
            font-size: 11.5px;
            color: var(--text-muted);
            margin-top: 3px;
            display: block;
        }

        .co-prod-sub {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--text-primary);
            flex-shrink: 0;
            font-variant-numeric: tabular-nums;
        }

        /* ── Summary ── */
        .co-summary-card { padding: 16px; }

        .co-sum-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 13.5px;
            color: var(--text-secondary);
            margin-bottom: 10px;
        }

        .co-sum-label { color: var(--text-secondary); }

        .co-sum-val {
            font-weight: 600;
            color: var(--text-primary);
            font-variant-numeric: tabular-nums;
        }

        .co-sum-free {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-weight: 700;
            color: var(--green);
            font-size: 12.5px;
        }

        .co-sum-divider { height: 1px; background: var(--border); margin: 4px 0 14px; }

        .co-sum-row--total {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 12px;
        }

        .co-sum-total {
            color: var(--accent);
            font-size: 17px;
            font-variant-numeric: tabular-nums;
        }

        .co-sum-note {
            display: flex;
            align-items: flex-start;
            gap: 6px;
            font-size: 11.5px;
            color: var(--text-muted);
            line-height: 1.5;
            padding: 10px 12px;
            background: var(--bg);
            border-radius: 8px;
            border: 1px solid var(--border);
        }

        /* ── Alert ── */
        .co-alert {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--green-soft);
            border: 1px solid #BBF7D0;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 13px;
            font-weight: 500;
            color: var(--green);
            margin-top: 4px;
        }

        /* ── Footer ── */
        .co-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 50;
            background: var(--surface);
            border-top: 1px solid var(--border);
            box-shadow: var(--shadow-footer);
            padding: 12px 16px;
            padding-bottom: calc(12px + env(safe-area-inset-bottom));
        }

        .co-footer__inner {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .co-footer__info { flex: 1; min-width: 0; }

        .co-footer__label {
            font-size: 11px;
            color: var(--text-muted);
            display: block;
            font-weight: 500;
        }

        .co-footer__val {
            font-size: 18px;
            font-weight: 800;
            color: var(--text-primary);
            font-variant-numeric: tabular-nums;
            letter-spacing: -.4px;
        }

        .co-footer__btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--accent);
            color: white;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: -.2px;
            border: none;
            border-radius: 13px;
            padding: 14px 22px;
            cursor: pointer;
            white-space: nowrap;
            flex-shrink: 0;
            box-shadow: 0 4px 16px rgba(37, 99, 235, .32);
            transition: opacity .15s, transform .1s;
        }

        .co-footer__btn:active   { opacity: .9; transform: scale(.98); }
        .co-footer__btn:disabled { opacity: .6; pointer-events: none; }

        @keyframes spin { to { transform: rotate(360deg); } }
        .co-spin { animation: spin .8s linear infinite; }
    </style>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

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
                if (r) r.checked = true;
            }
            localStorage.removeItem(CHECKOUT_STATE_KEY);
        }

        // ─────────────────────────────────────────────────────────────
        // LEAVE GUARD STATE
        // ─────────────────────────────────────────────────────────────
        let pendingNav    = null;
        let formDirty     = false;
        let isSubmitting  = false;

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

                    const elLabel  = document.getElementById('addrLabel');
                    const elDetail = document.getElementById('addrDetail');
                    const elBadge  = document.getElementById('addrBadge');
                    if (elLabel)  elLabel.textContent  = radio.dataset.label;
                    if (elDetail) elDetail.textContent = radio.dataset.address;
                    if (elBadge)  elBadge.style.display = radio.dataset.isDefault === '1' ? '' : 'none';

                    // Update hidden address_id
                    document.getElementById('selectedAddressId').value = chosenId;
                    formDirty = true;
                }
            }

            // Restore dari localStorage (kembali dari tambah alamat)
            restoreCheckoutState();

            // ── Payment method toggle ─────────────────────────────────
            const payRadios = document.querySelectorAll('input[name="payment_method"]');
            const payRows = {
                cod:      document.getElementById('payRowCod'),
                midtrans: document.getElementById('payRowMidtrans'),
            };

            function syncPayment() {
                const val = document.querySelector('input[name="payment_method"]:checked')?.value;
                payRows.cod.classList.toggle('co-pay-row--active',      val === 'cod');
                payRows.midtrans.classList.toggle('co-pay-row--active', val === 'midtrans');
            }

            payRadios.forEach(r => r.addEventListener('change', () => { syncPayment(); formDirty = true; }));
            syncPayment();

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

            // ── Submit ────────────────────────────────────────────────
            document.getElementById('checkoutForm').addEventListener('submit', function(e) {
                e.preventDefault();
                isSubmitting = true;

                const btn = document.getElementById('submitBtn');
                btn.disabled = true;
                btn.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.2" stroke-linecap="round" class="co-spin">
                    <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83
                             M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                </svg> Memproses...`;

                const paymentMethod = document.querySelector('input[name="payment_method"]:checked')?.value;

                // COD — submit form biasa
                if (paymentMethod === 'cod') {
                    this.submit();
                    return;
                }

                // Midtrans — pakai Snap
                fetch(`/payment/{{ $order->id }}/create`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        payment_method: paymentMethod,
                        address_id: document.getElementById('selectedAddressId').value,
                    }),
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.token) {
                        alert('Snap token tidak ditemukan');
                        btn.disabled = false;
                        btn.innerHTML = `Buat Pesanan`;
                        return;
                    }
                    window.snap.pay(data.token, {
                        onSuccess: () => { window.location.href = '/customer/order'; },
                        onPending: () => { window.location.href = '/customer/order'; },
                        onError:   () => {
                            alert('Pembayaran gagal, silakan coba lagi.');
                            btn.disabled = false;
                            btn.innerHTML = `Buat Pesanan`;
                        },
                        onClose:   () => {
                            btn.disabled = false;
                            btn.innerHTML = `Buat Pesanan`;
                        },
                    });
                })
                .catch(() => {
                    alert('Terjadi kesalahan, coba lagi.');
                    btn.disabled = false;
                    btn.innerHTML = `Buat Pesanan`;
                });
            });

            // Simpan state sebelum navigasi ke tambah alamat
            document.querySelector('.co-addr-add')?.addEventListener('click', saveCheckoutState);

            // ── Leave Guard ───────────────────────────────────────────
            const leaveSheet    = document.getElementById('leaveSheet');
            const leaveSheetBox = document.getElementById('leaveSheetBox');
            const leaveStay     = document.getElementById('leaveStay');
            const leaveConfirm  = document.getElementById('leaveConfirm');

            document.querySelectorAll('input[name="address_id"]')
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

            leaveStay.addEventListener('click',    () => closeLeaveSheet());
            leaveConfirm.addEventListener('click', () => closeLeaveSheet(() => doNavigate(pendingNav)));

            document.querySelector('.co-header__back')?.addEventListener('click', e => {
                if (isSubmitting || !formDirty) return;
                e.preventDefault();
                e.stopImmediatePropagation();
                openLeaveSheet('__back__');
            });

            document.addEventListener('click', e => {
                if (isSubmitting || !formDirty) return;
                const link = e.target.closest('a[href]');
                if (!link) return;
                if (link.classList.contains('co-header__back')) return;
                const href = link.getAttribute('href');
                if (!href) return;
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

            // ── Restore selected address from session (fallback) ──────
            const pendingAddr = sessionStorage.getItem('selected_address_id');
            if (pendingAddr) {
                document.getElementById('selectedAddressId').value = pendingAddr;
                sessionStorage.removeItem('selected_address_id');
            }

            // ── Note Bottom Sheet ─────────────────────────────────────
            const noteSheet      = document.getElementById('noteSheet');
            const noteSheetBox   = document.getElementById('noteSheetBox');
            const noteTextarea   = document.getElementById('noteTextarea');
            const noteHidden     = document.getElementById('noteHidden');
            const noteTrigger    = document.getElementById('openNoteSheet');
            const noteTriggerText = document.getElementById('noteTriggerText');
            const noteCountEl    = document.getElementById('noteCount');

            function openNoteSheet() {
                noteSheet.classList.add('open');
                document.body.style.overflow = 'hidden';
                setTimeout(() => noteTextarea.focus(), 300);
            }

            function closeNoteSheet() {
                noteSheetBox.style.animation = 'efSheetDown .22s cubic-bezier(.4,0,1,1) forwards';
                setTimeout(() => {
                    noteSheet.classList.remove('open');
                    noteSheetBox.style.animation = '';
                    document.body.style.overflow = '';
                }, 220);
            }

            function updateTrigger(val) {
                const hasNote = val.trim().length > 0;
                noteTrigger.classList.toggle('has-note', hasNote);
                noteTriggerText.textContent = hasNote
                    ? `📝 ${val.trim().length > 40 ? val.trim().slice(0, 40) + '…' : val.trim()}`
                    : 'Tambah catatan untuk kurir';
            }

            noteTrigger.addEventListener('click', openNoteSheet);
            document.getElementById('closeNoteSheet').addEventListener('click', closeNoteSheet);

            noteSheet.addEventListener('click', e => {
                if (e.target === noteSheet) closeNoteSheet();
            });

            document.querySelectorAll('.co-note-chip').forEach(chip => {
                chip.addEventListener('click', () => {
                    const isActive = chip.classList.contains('active');
                    document.querySelectorAll('.co-note-chip').forEach(c => c.classList.remove('active'));
                    if (!isActive) {
                        chip.classList.add('active');
                        noteTextarea.value = chip.dataset.note;
                    } else {
                        noteTextarea.value = '';
                    }
                    noteCountEl.textContent = noteTextarea.value.length;
                });
            });

            noteTextarea.addEventListener('input', () => {
                noteCountEl.textContent = noteTextarea.value.length;
                document.querySelectorAll('.co-note-chip').forEach(c => c.classList.remove('active'));
            });

            document.getElementById('saveNote').addEventListener('click', () => {
                const val = noteTextarea.value.trim();
                noteHidden.value = val;
                updateTrigger(val);
                closeNoteSheet();
                formDirty = true;
            });

            document.getElementById('clearNote').addEventListener('click', () => {
                noteTextarea.value  = '';
                noteHidden.value    = '';
                noteCountEl.textContent = '0';
                document.querySelectorAll('.co-note-chip').forEach(c => c.classList.remove('active'));
                updateTrigger('');
                closeNoteSheet();
            });
        });
    </script>

</x-app-layout>