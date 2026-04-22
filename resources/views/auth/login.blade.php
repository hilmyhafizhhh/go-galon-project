<x-guest-layout>
    <x-auth-session-status class="ef-login__status" :status="session('status')" />

    <div class="ef-login">

        {{-- ── Decorative background blobs ── --}}
        <div class="ef-login__bg" aria-hidden="true">
            <div class="ef-login__blob ef-login__blob--1"></div>
            <div class="ef-login__blob ef-login__blob--2"></div>
            <div class="ef-login__blob ef-login__blob--3"></div>
        </div>

        <div class="ef-login__wrap">

            {{-- ════ LEFT PANEL ════ --}}
            <div class="ef-login__left">
                <a href="{{ route('admin.dashboard') }}" class="ef-login__brand">
                    <img src="{{ asset('assets/icons/Frame 44.png') }}" alt="Brand Logo" class="ef-login__brand-img">
                </a>

                <div class="ef-login__left-copy">
                    <h2 class="ef-login__left-title">Air bersih,<br><em>langsung ke pintu Anda.</em></h2>
                    <p class="ef-login__left-sub">Platform pesan galon terpercaya — cepat, higienis, dan mudah.</p>
                </div>

                <div class="ef-login__features">
                    <div class="ef-login__feat">
                        <div class="ef-login__feat-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                            </svg>
                        </div>
                        <span>Pengantaran cepat & real-time</span>
                    </div>
                    <div class="ef-login__feat">
                        <div class="ef-login__feat-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            </svg>
                        </div>
                        <span>Produk terjamin & higienis</span>
                    </div>
                    <div class="ef-login__feat">
                        <div class="ef-login__feat-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                            </svg>
                        </div>
                        <span>Layanan pelanggan 24/7</span>
                    </div>
                </div>
            </div>

            {{-- ════ RIGHT: FORM ════ --}}
            <div class="ef-login__right">
                <div class="ef-login__card">

                    {{-- Mobile logo --}}
                    <div class="ef-login__mobile-logo">
                        <img src="{{ asset('assets/icons/Frame 44.png') }}" alt="Logo"
                            class="ef-login__mobile-logo-img">
                    </div>

                    <div class="ef-login__card-header">
                        <h1 class="ef-login__card-title">Selamat datang</h1>
                        <p class="ef-login__card-sub">Masuk ke akun Anda untuk melanjutkan</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="ef-login__form">
                        @csrf

                        {{-- Email / Username --}}
                        <div class="ef-field">
                            <label for="id_user" class="ef-field__label">Email atau Username</label>
                            <div class="ef-field__wrap">
                                <svg class="ef-field__icon" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                                <input id="id_user" name="id_user" type="text" value="{{ old('id_user') }}" required
                                    autofocus autocomplete="username" placeholder="contoh@email.com"
                                    class="ef-field__input">
                            </div>
                            <x-input-error :messages="$errors->get('id_user')" class="ef-field__error" />
                        </div>

                        {{-- Password --}}
                        <div class="ef-field" x-data="{ show: false }">
                            <label for="password" class="ef-field__label">Password</label>
                            <div class="ef-field__wrap">
                                <svg class="ef-field__icon" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                    <path d="M7 11V7a5 5 0 0110 0v4" />
                                </svg>
                                <input id="password" name="password" :type="show ? 'text' : 'password'" required
                                    autocomplete="current-password" placeholder="Masukkan password"
                                    class="ef-field__input ef-field__input--pw">
                                <button type="button" @click="show = !show" class="ef-field__eye" tabindex="-1">
                                    <svg x-show="!show" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                    <svg x-show="show" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24" />
                                        <line x1="1" y1="1" x2="23" y2="23" />
                                    </svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="ef-field__error" />
                        </div>

                        {{-- Remember + Forgot --}}
                        <div class="ef-login__meta">
                            <label class="ef-login__remember">
                                <input type="checkbox" name="remember" class="ef-login__checkbox">
                                <span>Ingat saya</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="ef-login__forgot">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="ef-login__submit">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4" />
                                <polyline points="10 17 15 12 10 7" />
                                <line x1="15" y1="12" x2="3" y2="12" />
                            </svg>
                            Masuk
                        </button>

                        {{-- Divider --}}
                        <div class="ef-login__divider">
                            <span>atau</span>
                        </div>

                        {{-- Google --}}
                        <a href="/auth/google/redirect" class="ef-login__google">
                            <svg width="18" height="18" viewBox="0 0 48 48">
                                <path fill="#EA4335"
                                    d="M24 9.5c3.5 0 6.5 1.2 8.9 3.6l6.6-6.6C35.6 2.4 30.2 0 24 0 14.6 0 6.6 5.4 2.6 13.2l7.7 6C12.3 12.2 17.7 9.5 24 9.5z" />
                                <path fill="#34A853"
                                    d="M46.1 24.6c0-1.6-.1-3.1-.4-4.6H24v9h12.4c-.6 3-2.4 5.5-5 7.2l7.7 6c4.5-4.2 7.1-10.4 7.1-17.6z" />
                                <path fill="#4A90E2"
                                    d="M24 48c6.5 0 12-2.1 16-5.8l-7.7-6c-2.1 1.4-4.8 2.2-8.3 2.2-6.4 0-11.8-4.3-13.7-10.1l-7.7 6C6.6 42.6 14.6 48 24 48z" />
                                <path fill="#FBBC05"
                                    d="M10.3 28.3c-.5-1.4-.8-3-.8-4.6s.3-3.2.8-4.6l-7.7-6C.9 15.9 0 19.4 0 23.7s.9 7.8 2.6 11.2l7.7-6z" />
                            </svg>
                            Masuk dengan Google
                        </a>

                        {{-- Register --}}
                        <p class="ef-login__register">
                            Belum punya akun?
                            <a href="{{ route('register') }}">Daftar di sini</a>
                        </p>
                    </form>
                </div>
            </div>

        </div>
    </div>


</x-guest-layout>