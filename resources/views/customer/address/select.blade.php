<x-app-layout>
    <div class="addr-root">

        {{-- ── Header ── --}}
        <div class="addr-header">
            <a href="javascript:history.back()" class="addr-header__back" aria-label="Kembali">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2"
                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M19 12H5M12 19l-7-7 7-7" />
                </svg>
            </a>
            <span class="addr-header__title">Alamat Saya</span>
            <div style="width:36px"></div>
        </div>

        {{-- ── Body ── --}}
        <div class="addr-body">

            @if ($addresses->isEmpty())
                {{-- ── Empty state ── --}}
                <div class="addr-empty">
                    <div class="addr-empty__icon">
                        <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <p class="addr-empty__title">Belum ada alamat</p>
                    <p class="addr-empty__sub">Tambahkan alamat pengiriman untuk melanjutkan checkout.</p>
                </div>
            @else
                {{-- ── Address list ── --}}
                <div class="addr-list">
                    @foreach ($addresses as $address)
                        <button type="button"
                            class="addr-item {{ $address->is_default ? 'addr-item--selected' : '' }}"
                            data-id="{{ $address->id }}"
                            onclick="selectAddress({{ $address->id }})">

                            <div class="addr-item__left">
                                <div class="addr-item__icon {{ $address->is_default ? 'addr-item__icon--active' : '' }}">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div class="addr-item__body">
                                    <div class="addr-item__top">
                                        <span class="addr-item__label">{{ $address->label }}</span>
                                        @if ($address->is_default)
                                            <span class="addr-chip addr-chip--primary">Utama</span>
                                        @endif
                                    </div>
                                    <p class="addr-item__text">{{ $address->address }}</p>
                                    {{-- action row --}}
                                    <div class="addr-item__actions" onclick="event.stopPropagation()">
                                        <a href="{{ route('customer.address.edit', $address) }}" class="addr-action-link">Edit</a>
                                        @if (!$address->is_default)
                                            <span class="addr-action-dot">·</span>
                                            <form method="POST" action="{{ route('customer.address.default', $address) }}" style="display:inline">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="addr-action-link">Jadikan Utama</button>
                                            </form>
                                            <span class="addr-action-dot">·</span>
                                            <form method="POST" action="{{ route('customer.address.destroy', $address) }}" style="display:inline"
                                                onsubmit="return confirm('Hapus alamat ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="addr-action-link addr-action-link--danger">Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="addr-item__radio {{ $address->is_default ? 'addr-item__radio--active' : '' }}">
                                <div class="addr-item__radio-dot"></div>
                            </div>
                        </button>
                    @endforeach
                </div>
            @endif

        </div>

        {{-- ── Sticky footer: add address button ── --}}
        <div class="addr-footer">
            <a href="{{ route('customer.address.create') }}" class="addr-add-btn">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.3"
                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14" />
                </svg>
                Tambah Alamat Baru
            </a>
        </div>

    </div>

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
            --danger: #DC2626;
            --danger-soft: #FEF2F2;
            --radius-card: 16px;
            --shadow-card: 0 1px 4px rgba(15,30,60,.06), 0 1px 2px rgba(15,30,60,.04);
            --shadow-footer: 0 -4px 28px rgba(15,30,60,.10);
        }

        body { background: var(--bg); font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Text', 'Segoe UI', sans-serif; color: var(--text-primary); }

        .addr-root { min-height: 100dvh; display: flex; flex-direction: column; }

        /* ── Header ── */
        .addr-header {
            position: sticky; top: 0; z-index: 50;
            display: flex; align-items: center; justify-content: space-between;
            padding: 14px 16px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
        }
        .addr-header__back {
            width: 36px; height: 36px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 50%; background: var(--bg);
            color: var(--text-primary); text-decoration: none;
            transition: background .15s;
        }
        .addr-header__back:active { background: var(--border); }
        .addr-header__title { font-size: 16px; font-weight: 700; color: var(--text-primary); letter-spacing: -.3px; }

        /* ── Body ── */
        .addr-body { flex: 1; padding: 20px 16px 100px; display: flex; flex-direction: column; gap: 10px; }

        /* ── Empty ── */
        .addr-empty {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            gap: 12px; padding: 60px 24px; text-align: center;
        }
        .addr-empty__icon {
            width: 68px; height: 68px; border-radius: 20px;
            background: var(--accent-soft); color: var(--accent);
            display: flex; align-items: center; justify-content: center;
        }
        .addr-empty__title { font-size: 16px; font-weight: 700; color: var(--text-primary); }
        .addr-empty__sub { font-size: 13.5px; color: var(--text-muted); line-height: 1.55; max-width: 240px; }

        /* ── Address list ── */
        .addr-list { display: flex; flex-direction: column; gap: 10px; }

        /* ── Address item ── */
        .addr-item {
            display: flex; align-items: flex-start; gap: 12px;
            width: 100%; text-align: left;
            background: var(--surface);
            border-radius: var(--radius-card);
            border: 1.5px solid var(--border);
            box-shadow: var(--shadow-card);
            padding: 15px 15px;
            cursor: pointer;
            transition: border-color .18s, box-shadow .18s;
            appearance: none;
        }
        .addr-item--selected {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-soft), var(--shadow-card);
        }
        .addr-item:active { opacity: .92; }

        .addr-item__left { display: flex; align-items: flex-start; gap: 12px; flex: 1; min-width: 0; }

        .addr-item__icon {
            width: 36px; height: 36px; flex-shrink: 0; border-radius: 10px;
            background: var(--bg); color: var(--text-muted);
            display: flex; align-items: center; justify-content: center;
            margin-top: 1px;
        }
        .addr-item__icon--active { background: var(--accent-soft); color: var(--accent); }

        .addr-item__body { flex: 1; min-width: 0; }
        .addr-item__top { display: flex; align-items: center; gap: 6px; margin-bottom: 3px; flex-wrap: wrap; }
        .addr-item__label { font-size: 14px; font-weight: 700; color: var(--text-primary); }
        .addr-item__text { font-size: 12.5px; color: var(--text-secondary); line-height: 1.5; margin-bottom: 8px; }

        .addr-item__actions { display: flex; align-items: center; gap: 5px; flex-wrap: wrap; }
        .addr-action-link {
            font-size: 12px; font-weight: 600; color: var(--accent);
            background: none; border: none; padding: 0; cursor: pointer;
            text-decoration: none; transition: opacity .12s;
        }
        .addr-action-link:active { opacity: .6; }
        .addr-action-link--danger { color: var(--danger); }
        .addr-action-dot { font-size: 12px; color: var(--text-muted); }

        /* ── Radio visual ── */
        .addr-item__radio {
            width: 20px; height: 20px; border-radius: 50%; flex-shrink: 0;
            border: 2px solid var(--border-mid);
            display: flex; align-items: center; justify-content: center;
            margin-top: 2px;
            transition: border-color .15s;
        }
        .addr-item__radio-dot { width: 8px; height: 8px; border-radius: 50%; background: transparent; transition: background .15s; }
        .addr-item__radio--active { border-color: var(--accent); }
        .addr-item__radio--active .addr-item__radio-dot { background: var(--accent); }

        /* ── Chip ── */
        .addr-chip { display: inline-flex; align-items: center; padding: 2px 7px; border-radius: 20px;
            font-size: 10px; font-weight: 700; letter-spacing: .3px; flex-shrink: 0; }
        .addr-chip--primary { background: var(--accent-soft); color: var(--accent); }

        /* ── Footer ── */
        .addr-footer {
            position: fixed; bottom: 0; left: 0; right: 0; z-index: 50;
            background: var(--surface);
            border-top: 1px solid var(--border);
            box-shadow: var(--shadow-footer);
            padding: 12px 16px;
            padding-bottom: calc(12px + env(safe-area-inset-bottom));
        }
        .addr-add-btn {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            width: 100%;
            background: var(--accent); color: white;
            font-size: 14px; font-weight: 700; letter-spacing: -.2px;
            border: none; border-radius: 13px; padding: 15px 22px;
            cursor: pointer; text-decoration: none;
            box-shadow: 0 4px 16px rgba(37,99,235,.28);
            transition: opacity .15s, transform .1s;
        }
        .addr-add-btn:active { opacity: .9; transform: scale(.98); }
    </style>

    <script>
        function selectAddress(id) {
            // Update visual state
            document.querySelectorAll('.addr-item').forEach(el => {
                const isThis = parseInt(el.dataset.id) === id;
                el.classList.toggle('addr-item--selected', isThis);
                const radio = el.querySelector('.addr-item__radio');
                const dot   = el.querySelector('.addr-item__radio-dot');
                const icon  = el.querySelector('.addr-item__icon');
                if (radio) radio.classList.toggle('addr-item__radio--active', isThis);
                if (dot)   dot.style.background = isThis ? 'var(--accent)' : 'transparent';
                if (icon)  {
                    icon.classList.toggle('addr-item__icon--active', isThis);
                }
            });

            // Store and navigate back to checkout
            sessionStorage.setItem('selected_address_id', id);
            setTimeout(() => history.back(), 220);
        }
    </script>
</x-app-layout>