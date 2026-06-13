<x-app-layout>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">


    {{-- Toast container --}}
    <div id="ef-profile-toast"></div>

    <div class="ef-profile">

        {{-- Header --}}
        <div class="ef-profile__header">
            <div class="ef-profile__header-inner">
                <a href="{{ url()->previous() }}" class="ef-profile__back" title="Kembali">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                </a>
                <div class="ef-profile__header-text">
                    <div class="ef-profile__hd-title">Edit Profil</div>
                    <div class="ef-profile__hd-sub">Kelola informasi akun kamu</div>
                </div>
                <div class="ef-profile__hd-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="ef-profile__body">
            @if($errors->any())
                <div class="ef-profile__alert ef-profile__alert--error" data-reveal>
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                    <div>
                        @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                    </div>
                </div>
            @endif


            {{-- Avatar card --}}
            <div class="ef-profile__avatar-card" data-reveal>
                <div class="ef-profile__avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                <div>
                    <div class="ef-profile__av-name">{{ $user->name }}</div>
                    <div class="ef-profile__av-email">{{ $user->email }}</div>
                    <span class="ef-profile__av-role">
                        @foreach($user->getRoleNames() as $role){{ $role }}@endforeach
                    </span>
                </div>
            </div>

            {{-- Form --}}
            <form method="POST" action="{{
    auth()->user()->hasRole('admin')
    ? route('admin.profile.update')
    : (auth()->user()->hasRole('courier')
        ? route('courier.profile.update')
        : route('customer.profile.update'))
                    }}">
                @csrf

                {{-- Informasi Pribadi --}}
                <div class="ef-profile__card" data-reveal>
                    <div class="ef-profile__card-hd">
                        <div class="ef-profile__card-icon">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </div>
                        <span class="ef-profile__card-title">Informasi Pribadi</span>
                    </div>
                    <div class="ef-profile__card-body">

                        <div class="ef-profile__row">
                            <div class="ef-profile__group">
                                <label class="ef-profile__label" for="name">Nama Lengkap</label>
                                <input type="text" id="name" name="name"
                                    class="ef-profile__input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                    value="{{ old('name', $user->name) }}" placeholder="Nama lengkap" required>
                                @error('name')<span class="ef-profile__error">{{ $message }}</span>@enderror
                            </div>

                            <div class="ef-profile__group">
                                <label class="ef-profile__label" for="username">Username</label>
                                <input type="text" id="username" name="username"
                                    class="ef-profile__input {{ $errors->has('username') ? 'is-invalid' : '' }}"
                                    value="{{ old('username', $user->username) }}" placeholder="username_kamu" required>
                                @error('username')<span class="ef-profile__error">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="ef-profile__group">
                            <label class="ef-profile__label" for="email">Email</label>
                            <input type="email" id="email" name="email"
                                class="ef-profile__input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                value="{{ old('email', $user->email) }}" placeholder="email@contoh.com" required>
                            @error('email')<span class="ef-profile__error">{{ $message }}</span>@enderror
                        </div>

                        <div class="ef-profile__group">
                            <label class="ef-profile__label" for="phone">Nomor HP</label>
                            <input type="tel" id="phone" name="phone"
                                class="ef-profile__input {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                value="{{ old('phone', $user->phone) }}" placeholder="08xx-xxxx-xxxx">
                            @error('phone')<span class="ef-profile__error">{{ $message }}</span>@enderror
                        </div>

                    </div>
                </div>

                {{-- Ganti Password --}}
                <div class="ef-profile__card" data-reveal style="margin-top:12px">
                    <div class="ef-profile__card-hd">
                        <div class="ef-profile__card-icon">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0110 0v4" />
                            </svg>
                        </div>
                        <span class="ef-profile__card-title">Ganti Password</span>
                    </div>
                    <div class="ef-profile__card-body">
                        <p class="ef-profile__hint">Kosongkan jika tidak ingin mengubah password.</p>

                        <div class="ef-profile__group">
                            <label class="ef-profile__label" for="current_password">Password Saat Ini</label>
                            <div class="ef-profile__input-wrap">
                                <input type="password" id="current_password" name="current_password"
                                    class="ef-profile__input {{ $errors->has('current_password') ? 'is-invalid' : '' }}"
                                    placeholder="••••••••" autocomplete="current-password">
                                <button type="button" class="ef-profile__pw-btn"
                                    onclick="efPwToggle('current_password', this)">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12S5 5 12 5s11 7 11 7-4 7-11 7S1 12 1 12z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </button>
                            </div>
                            @error('current_password')<span class="ef-profile__error">{{ $message }}</span>@enderror
                        </div>

                        <div class="ef-profile__row">
                            <div class="ef-profile__group">
                                <label class="ef-profile__label" for="password">Password Baru</label>
                                <div class="ef-profile__input-wrap">
                                    <input type="password" id="password" name="password"
                                        class="ef-profile__input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                        placeholder="Min. 8 karakter" autocomplete="new-password">
                                    <button type="button" class="ef-profile__pw-btn"
                                        onclick="efPwToggle('password', this)">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M1 12S5 5 12 5s11 7 11 7-4 7-11 7S1 12 1 12z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </button>
                                </div>
                                @error('password')<span class="ef-profile__error">{{ $message }}</span>@enderror
                            </div>

                            <div class="ef-profile__group">
                                <label class="ef-profile__label" for="password_confirmation">Konfirmasi Password</label>
                                <div class="ef-profile__input-wrap">
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="ef-profile__input" placeholder="Ulangi password baru"
                                        autocomplete="new-password">
                                    <button type="button" class="ef-profile__pw-btn"
                                        onclick="efPwToggle('password_confirmation', this)">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M1 12S5 5 12 5s11 7 11 7-4 7-11 7S1 12 1 12z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="ef-profile__save">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" />
                                <polyline points="17 21 17 13 7 13 7 21" />
                                <polyline points="7 3 7 8 15 8" />
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>

            </form>
            {{-- ── Alamat Saya ── --}}
            <div class="ef-profile__card" data-reveal style="margin-top:12px">
                <div class="ef-profile__card-hd">
                    <div class="ef-profile__card-icon">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span class="ef-profile__card-title">Alamat Saya</span>
                    <a href="{{ route('customer.address.create') }}" class="ef-addr-add-btn" style="margin-left:auto;">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.8"
                            stroke-linecap="round" viewBox="0 0 24 24">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                        Tambah
                    </a>
                </div>

                @php $addresses = auth()->user()->addresses()->orderByDesc('is_default')->get(); @endphp

                @if($addresses->isEmpty())
                    {{-- Empty state --}}
                    <div class="ef-addr-empty">
                        <div class="ef-addr-empty__icon">📍</div>
                        <p class="ef-addr-empty__title">Belum ada alamat</p>
                        <p class="ef-addr-empty__sub">Tambah alamat pengiriman untuk mulai memesan</p>
                        <a href="{{ route('customer.address.create') }}" class="ef-addr-empty__btn">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" viewBox="0 0 24 24">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                            Tambah Alamat Pertama
                        </a>
                    </div>
                @else
                    <div class="ef-addr-list">
                        @foreach($addresses as $addr)
                            <div class="ef-addr-item {{ $loop->last ? '' : 'ef-addr-item--border' }}">
                                <div class="ef-addr-item__icon">
                                    @if(str_contains(strtolower($addr->label), 'kantor'))
                                        🏢
                                    @elseif(str_contains(strtolower($addr->label), 'kos') || str_contains(strtolower($addr->label), 'apartemen'))
                                        🏠
                                    @else
                                        🏡
                                    @endif
                                </div>

                                <div class="ef-addr-item__body">
                                    <div class="ef-addr-item__top">
                                        <span class="ef-addr-item__label">{{ $addr->label }}</span>
                                        @if($addr->is_default)
                                            <span class="ef-addr-item__badge">Utama</span>
                                        @endif
                                    </div>
                                    <p class="ef-addr-item__detail">{{ Str::limit($addr->address, 60) }}</p>
                                </div>

                                <div class="ef-addr-item__actions">
                                    {{-- Jadikan utama --}}
                                    @if(!$addr->is_default)
                                        <form method="POST" action="{{ route('customer.address.default', $addr->id) }}"
                                            style="display:inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="ef-addr-action ef-addr-action--star"
                                                title="Jadikan alamat utama">
                                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Edit --}}
                                    <a href="{{ route('customer.address.edit', $addr->id) }}"
                                        class="ef-addr-action ef-addr-action--edit" title="Edit alamat">
                                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </a>

                                    {{-- Hapus --}}
                                    @if(!$addr->is_default || $addresses->count() === 1)
                                        <form method="POST" action="{{ route('customer.address.destroy', $addr->id) }}"
                                            onsubmit="return confirm('Hapus alamat ini?')" style="display:inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="ef-addr-action ef-addr-action--del" title="Hapus alamat">
                                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>


    <style>
        /* ── Root ──────────────────────────────────────────────────── */
        .ef-profile {
            font-family: "Plus Jakarta Sans", sans-serif;
            background: #f0f6ff;
            min-height: calc(100vh - 64px);
            padding-bottom: 40px;
        }

        .dark .ef-profile {
            background: #0b1120;
        }

        /* ── Sticky Header ─────────────────────────────────────────── */
        .ef-profile__header {
            position: sticky;
            top: 0;
            z-index: 40;
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border-bottom: 1px solid rgba(37, 99, 235, 0.1);
            box-shadow: 0 2px 16px rgba(37, 99, 235, 0.06);
        }

        .dark .ef-profile__header {
            background: rgba(15, 23, 42, 0.94);
            border-bottom-color: rgba(255, 255, 255, 0.06);
        }

        .ef-profile__header-inner {
            max-width: 640px;
            margin: 0 auto;
            padding: 14px 16px;
            min-height: 60px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: efFadeDown .18s ease;
        }

        @media (min-width: 640px) {
            .ef-profile__header-inner {
                padding: 16px 24px;
            }
        }

        @keyframes efFadeDown {
            from {
                opacity: 0;
                transform: translateY(-3px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .ef-profile__back {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: #eff6ff;
            border: 1px solid rgba(37, 99, 235, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            text-decoration: none;
            flex-shrink: 0;
            transition: background .15s, box-shadow .15s, transform .15s;
        }

        .ef-profile__back:hover {
            background: #dbeafe;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);
            transform: translateX(-1px);
        }

        .dark .ef-profile__back {
            background: rgba(37, 99, 235, 0.12);
            border-color: rgba(37, 99, 235, 0.25);
            color: #60a5fa;
        }

        .ef-profile__header-text {
            flex: 1;
            min-width: 0;
        }

        .ef-profile__hd-title {
            font-size: 1.15rem;
            font-weight: 800;
            color: #1e293b;
            line-height: 1;
        }

        .dark .ef-profile__hd-title {
            color: #f1f5f9;
        }

        .ef-profile__hd-sub {
            font-size: .73rem;
            color: #94a3b8;
            margin-top: 3px;
            font-weight: 500;
        }

        .ef-profile__hd-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: #eff6ff;
            border: 1px solid rgba(37, 99, 235, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            flex-shrink: 0;
        }

        .dark .ef-profile__hd-icon {
            background: rgba(37, 99, 235, 0.12);
            border-color: rgba(37, 99, 235, 0.25);
            color: #60a5fa;
        }

        /* ── Body ──────────────────────────────────────────────────── */
        .ef-profile__body {
            max-width: 640px;
            margin: 0 auto;
            padding: 20px 14px 0;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        @media (min-width: 640px) {
            .ef-profile__body {
                padding: 24px 24px 0;
            }
        }

        /* ── Reveal ────────────────────────────────────────────────── */
        [data-reveal] {
            opacity: 0;
            transform: translateY(16px);
            transition:
                opacity .42s cubic-bezier(.22, 1, .36, 1),
                transform .42s cubic-bezier(.22, 1, .36, 1);
        }

        [data-reveal].ef-revealed {
            opacity: 1;
            transform: none;
        }

        /* ── Alert ─────────────────────────────────────────────────── */
        .ef-profile__alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 11px 14px;
            border-radius: 13px;
            font-size: .82rem;
            font-weight: 600;
            line-height: 1.5;
        }

        .ef-profile__alert svg {
            flex-shrink: 0;
            margin-top: 1px;
        }

        .ef-profile__alert--success {
            background: rgba(34, 197, 94, .08);
            border: 1px solid rgba(34, 197, 94, .25);
            color: #16a34a;
        }

        .dark .ef-profile__alert--success {
            color: #4ade80;
        }

        .ef-profile__alert--error {
            background: rgba(225, 29, 72, .07);
            border: 1px solid rgba(225, 29, 72, .2);
            color: #e11d48;
        }

        /* ── Avatar Card ───────────────────────────────────────────── */
        .ef-profile__avatar-card {
            background: rgba(255, 255, 255, .97);
            border: 1px solid rgba(37, 99, 235, .08);
            border-radius: 16px;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 1px 6px rgba(37, 99, 235, .05);
        }

        .dark .ef-profile__avatar-card {
            background: rgba(17, 24, 39, .95);
            border-color: rgba(255, 255, 255, .07);
        }

        .ef-profile__avatar {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            font-weight: 800;
            color: #fff;
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(37, 99, 235, .35);
            letter-spacing: -.02em;
        }

        .ef-profile__av-name {
            font-size: .95rem;
            font-weight: 800;
            color: #1e293b;
        }

        .dark .ef-profile__av-name {
            color: #f1f5f9;
        }

        .ef-profile__av-email {
            font-size: .73rem;
            color: #94a3b8;
            margin-top: 2px;
            font-weight: 500;
        }

        .ef-profile__av-role {
            display: inline-block;
            margin-top: 6px;
            padding: 2px 10px;
            border-radius: 999px;
            background: #eff6ff;
            border: 1px solid rgba(37, 99, 235, .2);
            color: #2563eb;
            font-size: .67rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .dark .ef-profile__av-role {
            background: rgba(37, 99, 235, .12);
            border-color: rgba(37, 99, 235, .3);
            color: #60a5fa;
        }

        /* ── Card ──────────────────────────────────────────────────── */
        .ef-profile__card {
            background: rgba(255, 255, 255, .97);
            border: 1px solid rgba(37, 99, 235, .08);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 6px rgba(37, 99, 235, .05);
        }

        .dark .ef-profile__card {
            background: rgba(17, 24, 39, .95);
            border-color: rgba(255, 255, 255, .07);
        }

        .ef-profile__card-hd {
            padding: 12px 16px;
            border-bottom: 1px solid rgba(37, 99, 235, .07);
            display: flex;
            align-items: center;
            gap: 9px;
            background: rgba(239, 246, 255, .5);
        }

        .dark .ef-profile__card-hd {
            background: rgba(37, 99, 235, .04);
            border-bottom-color: rgba(255, 255, 255, .06);
        }

        .ef-profile__card-icon {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: #eff6ff;
            border: 1px solid rgba(37, 99, 235, .15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            flex-shrink: 0;
        }

        .dark .ef-profile__card-icon {
            background: rgba(37, 99, 235, .12);
            border-color: rgba(37, 99, 235, .25);
            color: #60a5fa;
        }

        .ef-profile__card-title {
            font-size: .82rem;
            font-weight: 800;
            color: #1e293b;
            letter-spacing: -.01em;
        }

        .dark .ef-profile__card-title {
            color: #f1f5f9;
        }

        .ef-profile__card-body {
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 13px;
        }

        /* ── Form elements ─────────────────────────────────────────── */
        .ef-profile__row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        @media (max-width: 480px) {
            .ef-profile__row {
                grid-template-columns: 1fr;
            }
        }

        .ef-profile__group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .ef-profile__label {
            font-size: .72rem;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .ef-profile__input {
            width: 100%;
            background: #f8faff;
            border: 1.5px solid rgba(37, 99, 235, .1);
            border-radius: 10px;
            padding: 9px 12px;
            font-size: .875rem;
            font-weight: 500;
            color: #1e293b;
            font-family: "Plus Jakarta Sans", sans-serif;
            outline: none;
            transition: border-color .18s, box-shadow .18s, background .18s;
            box-sizing: border-box;
        }

        .dark .ef-profile__input {
            background: #0f172a;
            border-color: rgba(255, 255, 255, .1);
            color: #f1f5f9;
        }

        .ef-profile__input::placeholder {
            color: #cbd5e1;
        }

        .dark .ef-profile__input::placeholder {
            color: #475569;
        }

        .ef-profile__input:focus {
            border-color: #2563eb;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
        }

        .dark .ef-profile__input:focus {
            background: #1e293b;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .2);
        }

        .ef-profile__input.is-invalid {
            border-color: #e11d48;
            box-shadow: 0 0 0 3px rgba(225, 29, 72, .1);
        }

        .ef-profile__error {
            font-size: .72rem;
            color: #e11d48;
            font-weight: 600;
        }

        .ef-profile__hint {
            font-size: .73rem;
            color: #94a3b8;
            font-weight: 500;
            line-height: 1.5;
        }

        /* ── Password with toggle ──────────────────────────────────── */
        .ef-profile__input-wrap {
            position: relative;
        }

        .ef-profile__input-wrap .ef-profile__input {
            padding-right: 40px;
        }

        .ef-profile__pw-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #94a3b8;
            padding: 0;
            display: flex;
            align-items: center;
            transition: color .15s;
            line-height: 0;
        }

        .ef-profile__pw-btn:hover {
            color: #2563eb;
        }

        .dark .ef-profile__pw-btn:hover {
            color: #60a5fa;
        }

        /* ── Save button ───────────────────────────────────────────── */
        .ef-profile__save {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 22px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: .86rem;
            font-weight: 700;
            border: none;
            border-radius: 11px;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(37, 99, 235, .35);
            transition: box-shadow .2s, transform .15s;
            align-self: flex-end;
            letter-spacing: -.01em;
        }

        .ef-profile__save:hover {
            box-shadow: 0 6px 20px rgba(37, 99, 235, .45);
            transform: translateY(-1px);
        }

        .ef-profile__save:active {
            transform: none;
        }

        /* ── Toast ─────────────────────────────────────────────────── */
        #ef-profile-toast {
            position: fixed;
            bottom: 32px;
            right: 14px;
            z-index: 9998;
            display: flex;
            flex-direction: column;
            gap: 8px;
            pointer-events: none;
        }

        @media (min-width: 640px) {
            #ef-profile-toast {
                right: 24px;
                bottom: 40px;
            }
        }

        .ef-toast {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: .82rem;
            font-weight: 600;
            padding: 11px 16px;
            border-radius: 12px;
            box-shadow: 0 8px 28px rgba(0, 0, 0, .18);
            opacity: 0;
            transform: translateY(10px) scale(.96);
            transition: all .32s cubic-bezier(.22, 1, .36, 1);
            border-left: 3px solid transparent;
            white-space: nowrap;
            background: #1e293b;
            color: #f1f5f9;
        }

        .ef-toast--show {
            opacity: 1;
            transform: none;
        }

        .ef-toast--success {
            border-left-color: #22c55e;
        }

        .ef-toast--success svg {
            color: #22c55e;
        }

        .ef-toast--error {
            border-left-color: #e11d48;
        }

        .ef-toast--error svg {
            color: #e11d48;
        }

        .ef-addr-add-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            background: #eff6ff;
            border: 1px solid #dbeafe;
            border-radius: 999px;
            color: #2563eb;
            font-size: .72rem;
            font-weight: 700;
            text-decoration: none;
            transition: background .15s;
        }

        .ef-addr-add-btn:hover {
            background: #dbeafe;
        }

        /* ── Empty state ── */
        .ef-addr-empty {
            text-align: center;
            padding: 2rem 1.25rem;
        }

        .ef-addr-empty__icon {
            font-size: 2rem;
            margin-bottom: .6rem;
        }

        .ef-addr-empty__title {
            font-size: .9rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: .25rem;
        }

        .ef-addr-empty__sub {
            font-size: .75rem;
            color: #94a3b8;
            margin-bottom: 1rem;
        }

        .ef-addr-empty__btn {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .6rem 1.2rem;
            background: #2563eb;
            color: #fff;
            border-radius: 10px;
            font-size: .78rem;
            font-weight: 700;
            text-decoration: none;
            transition: background .15s;
        }

        .ef-addr-empty__btn:hover {
            background: #1d4ed8;
        }

        /* ── Address list ── */
        .ef-addr-list {
            padding: 0;
        }

        .ef-addr-item {
            display: flex;
            align-items: flex-start;
            gap: .85rem;
            padding: .9rem 1rem;
        }

        .ef-addr-item--border {
            border-bottom: 1px solid rgba(37, 99, 235, .07);
        }

        .ef-addr-item__icon {
            font-size: 1.25rem;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .ef-addr-item__body {
            flex: 1;
            min-width: 0;
        }

        .ef-addr-item__top {
            display: flex;
            align-items: center;
            gap: .5rem;
            margin-bottom: 3px;
        }

        .ef-addr-item__label {
            font-size: .85rem;
            font-weight: 700;
            color: #1e293b;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ef-addr-item__badge {
            font-size: .6rem;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 999px;
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #dbeafe;
            flex-shrink: 0;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .ef-addr-item__detail {
            font-size: .75rem;
            color: #64748b;
            line-height: 1.45;
        }

        /* ── Action buttons ── */
        .ef-addr-item__actions {
            display: flex;
            align-items: center;
            gap: .3rem;
            flex-shrink: 0;
        }

        .ef-addr-action {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: background .15s;
            background: transparent;
        }

        .ef-addr-action--star {
            color: #94a3b8;
        }

        .ef-addr-action--star:hover {
            background: #fffbeb;
            color: #d97706;
        }

        .ef-addr-action--edit {
            color: #94a3b8;
        }

        .ef-addr-action--edit:hover {
            background: #eff6ff;
            color: #2563eb;
        }

        .ef-addr-action--del {
            color: #94a3b8;
        }

        .ef-addr-action--del:hover {
            background: #fef2f2;
            color: #dc2626;
        }
    </style>

    <script>
        (function () {
            // Staggered reveal
            document.querySelectorAll('[data-reveal]').forEach((el, i) => {
                setTimeout(() => el.classList.add('ef-revealed'), 60 + i * 70);
            });

            // Toast
            function efToast(msg, type) {
                const wrap = document.getElementById('ef-profile-toast');
                const icon = type === 'success'
                    ? `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>`
                    : `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`;
                const t = document.createElement('div');
                t.className = `ef-toast ef-toast--${type}`;
                t.innerHTML = icon + msg;
                wrap.appendChild(t);
                requestAnimationFrame(() => requestAnimationFrame(() => t.classList.add('ef-toast--show')));
                setTimeout(() => { t.classList.remove('ef-toast--show'); setTimeout(() => t.remove(), 400); }, 3200);
            }

            @if(session('success'))
                setTimeout(() => efToast('{{ session('success') }}', 'success'), 300);
            @endif

            // Password toggle
            window.efPwToggle = function (id, btn) {
                const inp = document.getElementById(id);
                const show = inp.type === 'password';
                inp.type = show ? 'text' : 'password';
                btn.innerHTML = show
                    ? `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
                    : `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12S5 5 12 5s11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>`;
            };
        })();
    </script>

</x-app-layout>