<x-app-layout>

    {{-- ── Styles ── --}}
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap");

        .ap-root {
            font-family: "Plus Jakarta Sans", sans-serif;
            background: #f0f6ff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .dark .ap-root { background: #0b1120; }

        /* ── Header ── */
        .ap-header {
            position: sticky;
            top: 0;
            z-index: 40;
            background: rgba(255,255,255,0.94);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border-bottom: 1px solid rgba(37,99,235,0.10);
            box-shadow: 0 2px 16px rgba(37,99,235,0.06);
        }
        .dark .ap-header {
            background: rgba(15,23,42,0.94);
            border-bottom-color: rgba(255,255,255,0.06);
        }
        .ap-header__inner {
            max-width: 720px;
            margin: 0 auto;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .ap-header__back {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: #eff6ff;
            border: 1px solid rgba(37,99,235,0.15);
            display: flex; align-items: center; justify-content: center;
            color: #2563eb;
            text-decoration: none;
            flex-shrink: 0;
            transition: background 0.15s, box-shadow 0.15s;
        }
        .ap-header__back:hover { background: #dbeafe; box-shadow: 0 2px 8px rgba(37,99,235,0.12); }
        .dark .ap-header__back { background: rgba(37,99,235,0.12); border-color: rgba(37,99,235,0.25); color: #60a5fa; }
        .ap-header__title { font-size: 1.08rem; font-weight: 800; color: #1e293b; }
        .dark .ap-header__title { color: #f1f5f9; }
        .ap-header__sub { font-size: 0.72rem; color: #94a3b8; font-weight: 500; margin-top: 1px; }

        /* ── Body ── */
        .ap-body {
            flex: 1;
            max-width: 720px;
            width: 100%;
            margin: 0 auto;
            padding: 16px 14px 32px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* ── Add new address button ── */
        .ap-add-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 13px 15px;
            background: #fff;
            border: 1.5px dashed rgba(37,99,235,0.3);
            border-radius: 14px;
            color: #2563eb;
            font-family: inherit;
            font-size: 0.84rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: border-color 0.15s, background 0.15s, box-shadow 0.15s;
        }
        .ap-add-btn:hover {
            background: #eff6ff;
            border-color: rgba(37,99,235,0.55);
            box-shadow: 0 2px 12px rgba(37,99,235,0.08);
        }
        .dark .ap-add-btn { background: #0f172a; border-color: rgba(96,165,250,0.28); color: #60a5fa; }
        .ap-add-btn__icon {
            width: 30px; height: 30px;
            border-radius: 8px;
            background: #eff6ff;
            border: 1px solid rgba(37,99,235,0.15);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .dark .ap-add-btn__icon { background: rgba(37,99,235,0.12); border-color: rgba(37,99,235,0.25); }

        /* ── Address Card ── */
        .ap-addr-card {
            background: #fff;
            border-radius: 16px;
            border: 1.5px solid #e2e8f0;
            overflow: hidden;
            cursor: pointer;
            transition: border-color 0.15s, box-shadow 0.15s;
            position: relative;
        }
        .dark .ap-addr-card { background: #0f172a; border-color: rgba(255,255,255,0.08); }
        .ap-addr-card:hover { border-color: rgba(37,99,235,0.35); box-shadow: 0 2px 16px rgba(37,99,235,0.08); }

        .ap-addr-card.selected {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.10), 0 2px 16px rgba(37,99,235,0.10);
        }

        /* Hidden radio */
        .ap-addr-card input[type="radio"] { display: none; }

        .ap-addr-card__inner {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 15px;
        }

        /* Radio circle */
        .ap-radio {
            width: 18px; height: 18px;
            border-radius: 50%;
            border: 2px solid #cbd5e1;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            margin-top: 2px;
            transition: border-color 0.15s;
        }
        .ap-addr-card.selected .ap-radio {
            border-color: #2563eb;
        }
        .ap-radio__dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: #2563eb;
            opacity: 0;
            transform: scale(0.5);
            transition: opacity 0.15s, transform 0.15s;
        }
        .ap-addr-card.selected .ap-radio__dot { opacity: 1; transform: scale(1); }

        .ap-addr-info { flex: 1; min-width: 0; }

        .ap-addr-top {
            display: flex;
            align-items: center;
            gap: 7px;
            flex-wrap: wrap;
            margin-bottom: 4px;
        }
        .ap-addr-label {
            font-size: 0.875rem;
            font-weight: 700;
            color: #1e293b;
        }
        .dark .ap-addr-label { color: #f1f5f9; }

        .ap-badge {
            font-size: 0.64rem;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 99px;
            letter-spacing: 0.02em;
        }
        .ap-badge--blue {
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid rgba(37,99,235,0.18);
        }

        .ap-addr-detail {
            font-size: 0.78rem;
            color: #64748b;
            line-height: 1.5;
        }
        .dark .ap-addr-detail { color: #94a3b8; }

        /* Divider */
        .ap-addr-card__divider {
            height: 1px;
            background: #f1f5f9;
            margin: 0 15px;
        }
        .dark .ap-addr-card__divider { background: rgba(255,255,255,0.05); }

        /* Footer of card: edit link */
        .ap-addr-card__footer {
            padding: 9px 15px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }
        .ap-addr-edit {
            font-size: 0.76rem;
            font-weight: 700;
            color: #2563eb;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 4px 8px;
            border-radius: 7px;
            transition: background 0.12s;
        }
        .ap-addr-edit:hover { background: #eff6ff; }
        .dark .ap-addr-edit { color: #60a5fa; }
        .dark .ap-addr-edit:hover { background: rgba(37,99,235,0.12); }

        /* ── Sticky bottom ── */
        .ap-footer {
            position: sticky;
            bottom: 0;
            z-index: 30;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(14px);
            border-top: 1px solid rgba(37,99,235,0.10);
            box-shadow: 0 -4px 20px rgba(37,99,235,0.08);
        }
        .dark .ap-footer { background: rgba(15,23,42,0.96); border-top-color: rgba(255,255,255,0.06); }
        .ap-footer__inner {
            max-width: 720px;
            margin: 0 auto;
            padding: 12px 16px;
        }
        .ap-footer__btn {
            width: 100%;
            padding: 14px 20px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #fff;
            font-family: inherit;
            font-size: 0.925rem;
            font-weight: 800;
            border: none;
            border-radius: 13px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 16px rgba(37,99,235,0.30);
            transition: transform 0.13s, box-shadow 0.13s, opacity 0.13s;
        }
        .ap-footer__btn:active { transform: scale(0.98); box-shadow: 0 2px 8px rgba(37,99,235,0.25); }
        .ap-footer__btn:disabled { opacity: 0.55; cursor: not-allowed; }

        /* ── Empty state ── */
        .ap-empty {
            text-align: center;
            padding: 40px 20px;
            color: #94a3b8;
        }
        .ap-empty svg { margin: 0 auto 12px; opacity: 0.35; display: block; }
        .ap-empty p { font-size: 0.85rem; font-weight: 600; }
    </style>

    <div class="ap-root">

        {{-- Header --}}
        <div class="ap-header">
            <div class="ap-header__inner">
                <a href="{{ route('customer.checkout') }}" class="ap-header__back" aria-label="Kembali">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <div class="ap-header__title">Pilih Alamat</div>
                    <div class="ap-header__sub">{{ $addresses->count() }} alamat tersimpan</div>
                </div>
            </div>
        </div>

        <div class="ap-body">

            {{-- Add new address --}}
            <a href="{{ route('customer.address.create') }}" class="ap-add-btn">
                <div class="ap-add-btn__icon">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" viewBox="0 0 24 24">
                        <path d="M12 5v14M5 12h14" />
                    </svg>
                </div>
                Tambah Alamat Baru
            </a>

            {{-- Address list --}}
            @if ($addresses->isEmpty())
                <div class="ap-empty">
                    <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <p>Belum ada alamat. Tambah sekarang!</p>
                </div>
            @else
                @foreach ($addresses as $address)
                    <div class="ap-addr-card {{ $address->is_default ? 'selected' : '' }}"
                        data-id="{{ $address->id }}"
                        onclick="selectAddress(this, '{{ $address->id }}')">
                        <input type="radio" name="address_id" value="{{ $address->id }}"
                            {{ $address->is_default ? 'checked' : '' }}>
                        <div class="ap-addr-card__inner">
                            <div class="ap-radio">
                                <div class="ap-radio__dot"></div>
                            </div>
                            <div class="ap-addr-info">
                                <div class="ap-addr-top">
                                    <span class="ap-addr-label">{{ $address->label }}</span>
                                    @if ($address->is_default)
                                        <span class="ap-badge ap-badge--blue">Utama</span>
                                    @endif
                                </div>
                                <div class="ap-addr-detail">{{ $address->address }}</div>
                            </div>
                        </div>
                        <div class="ap-addr-card__divider"></div>
                        <div class="ap-addr-card__footer">
                            <a href="{{ route('customer.address.edit', $address->id) }}"
                                class="ap-addr-edit"
                                onclick="event.stopPropagation()">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"
                                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
                                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                                Ubah
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>

        {{-- Sticky footer --}}
        <div class="ap-footer">
            <div class="ap-footer__inner">
                <button type="button" class="ap-footer__btn" id="confirmBtn" onclick="confirmAddress()">
                    Gunakan Alamat Ini
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

    </div>

    <script>
        let selectedId = '{{ $addresses->where("is_default", true)->first()?->id ?? $addresses->first()?->id }}';

        function selectAddress(card, id) {
            // Deselect all
            document.querySelectorAll('.ap-addr-card').forEach(c => c.classList.remove('selected'));
            document.querySelectorAll('input[name="address_id"]').forEach(r => r.checked = false);

            // Select clicked
            card.classList.add('selected');
            card.querySelector('input[type="radio"]').checked = true;
            selectedId = id;
        }

        function confirmAddress() {
            if (!selectedId) return;
            // Pass chosen address id back to checkout via sessionStorage
            sessionStorage.setItem('chosen_address_id', selectedId);
            window.history.back();
        }
    </script>

</x-app-layout>