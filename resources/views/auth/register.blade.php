<x-guest-layout>
    <div class="ef-reg">

        {{-- ── Decorative blobs ── --}}
        <div class="ef-reg__bg" aria-hidden="true">
            <div class="ef-reg__blob ef-reg__blob--1"></div>
            <div class="ef-reg__blob ef-reg__blob--2"></div>
            <div class="ef-reg__blob ef-reg__blob--3"></div>
        </div>

        <div class="ef-reg__wrap">

            {{-- ════ LEFT PANEL ════ --}}
            <div class="ef-reg__left">
                <a href="{{ route('admin.dashboard') }}" class="ef-reg__brand">
                    <img src="{{ asset('assets/icons/Frame 44.png') }}" alt="Brand Logo" class="ef-reg__brand-img">
                </a>

                <div class="ef-reg__left-copy">
                    <h2 class="ef-reg__left-title">Bergabung<br><em>bersama kami.</em></h2>
                    <p class="ef-reg__left-sub">Daftar sekarang dan nikmati layanan pengiriman galon premium langsung ke
                        rumah Anda.</p>
                </div>

                <div class="ef-reg__steps">
                    <div class="ef-reg__step">
                        <div class="ef-reg__step-num">1</div>
                        <div>
                            <p class="ef-reg__step-title">Buat akun</p>
                            <p class="ef-reg__step-sub">Isi data diri dengan mudah</p>
                        </div>
                    </div>
                    <div class="ef-reg__step-line"></div>
                    <div class="ef-reg__step">
                        <div class="ef-reg__step-num">2</div>
                        <div>
                            <p class="ef-reg__step-title">Pilih produk</p>
                            <p class="ef-reg__step-sub">Berbagai pilihan galon premium</p>
                        </div>
                    </div>
                    <div class="ef-reg__step-line"></div>
                    <div class="ef-reg__step">
                        <div class="ef-reg__step-num">3</div>
                        <div>
                            <p class="ef-reg__step-title">Terima di rumah</p>
                            <p class="ef-reg__step-sub">Kurir kami antar cepat & aman</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ════ RIGHT: FORM ════ --}}
            <div class="ef-reg__right">
                <div class="ef-reg__card">

                    {{-- Mobile logo --}}
                    <div class="ef-reg__mobile-logo">
                        <img src="{{ asset('assets/icons/Frame 44.png') }}" alt="Logo" class="ef-reg__mobile-logo-img">
                    </div>

                    <div class="ef-reg__card-header">
                        <h1 class="ef-reg__card-title">Buat Akun Baru</h1>
                        <p class="ef-reg__card-sub">Isi formulir di bawah untuk mendaftar</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="ef-reg__form">
                        @csrf

                        {{-- Row: Nama + Username --}}
                        <div class="ef-reg__row">
                            <div class="ef-field">
                                <label for="name" class="ef-field__label">Nama Lengkap</label>
                                <div class="ef-field__wrap">
                                    <svg class="ef-field__icon" width="15" height="15" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                                        <circle cx="12" cy="7" r="4" />
                                    </svg>
                                    <input id="name" name="name" type="text" value="{{ old('name') }}" required
                                        autofocus autocomplete="name" placeholder="John Doe" class="ef-field__input">
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="ef-field__error" />
                            </div>

                            <div class="ef-field">
                                <label for="username" class="ef-field__label">Username</label>
                                <div class="ef-field__wrap">
                                    <svg class="ef-field__icon" width="15" height="15" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M20 14.66V20a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2h5.34" />
                                        <polygon points="18 2 22 6 12 16 8 16 8 12 18 2" />
                                    </svg>
                                    <input id="username" name="username" type="text" value="{{ old('username') }}"
                                        required autocomplete="username" placeholder="johndoe" class="ef-field__input">
                                </div>
                                <x-input-error :messages="$errors->get('username')" class="ef-field__error" />
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="ef-field">
                            <label for="email" class="ef-field__label">Email</label>
                            <div class="ef-field__wrap">
                                <svg class="ef-field__icon" width="15" height="15" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                    <polyline points="22,6 12,13 2,6" />
                                </svg>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                                    autocomplete="email" placeholder="contoh@email.com" class="ef-field__input">
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="ef-field__error" />
                        </div>

                        {{-- Row: Password + Konfirmasi --}}
                        <div class="ef-reg__row">
                            <div class="ef-field" x-data="{ show: false }">
                                <label for="password" class="ef-field__label">Password</label>
                                <div class="ef-field__wrap">
                                    <svg class="ef-field__icon" width="15" height="15" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                        <path d="M7 11V7a5 5 0 0110 0v4" />
                                    </svg>
                                    <input id="password" name="password" :type="show ? 'text' : 'password'" required
                                        autocomplete="new-password" placeholder="Min. 8 karakter"
                                        class="ef-field__input ef-field__input--pw">
                                    <button type="button" @click="show = !show" class="ef-field__eye" tabindex="-1">
                                        <svg x-show="!show" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                        <svg x-show="show" width="14" height="14" viewBox="0 0 24 24" fill="none"
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

                            <div class="ef-field" x-data="{ show: false }">
                                <label for="password_confirmation" class="ef-field__label">Konfirmasi Password</label>
                                <div class="ef-field__wrap">
                                    <svg class="ef-field__icon" width="15" height="15" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                    </svg>
                                    <input id="password_confirmation" name="password_confirmation"
                                        :type="show ? 'text' : 'password'" required autocomplete="new-password"
                                        placeholder="Ulangi password" class="ef-field__input ef-field__input--pw">
                                    <button type="button" @click="show = !show" class="ef-field__eye" tabindex="-1">
                                        <svg x-show="!show" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                        <svg x-show="show" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path
                                                d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24" />
                                            <line x1="1" y1="1" x2="23" y2="23" />
                                        </svg>
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->get('password_confirmation')"
                                    class="ef-field__error" />
                            </div>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="ef-reg__submit">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                                <circle cx="8.5" cy="7" r="4" />
                                <line x1="20" y1="8" x2="20" y2="14" />
                                <line x1="23" y1="11" x2="17" y2="11" />
                            </svg>
                            Daftar Sekarang
                        </button>

                        {{-- Login link --}}
                        <p class="ef-reg__login-link">
                            Sudah punya akun?
                            <a href="{{ route('login') }}">Masuk di sini</a>
                        </p>

                    </form>
                </div>
            </div>

        </div>
    </div>



</x-guest-layout>