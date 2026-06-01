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
                    <img src="{{ asset('assets/icons/Frame 44.webp') }}" alt="Brand Logo" class="ef-reg__brand-img">
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

                    <form method="POST" action="{{ route('register') }}" class="ef-reg__form" id="registerForm">
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

                        {{-- ── Terms & Conditions ── --}}
                        <div class="ef-terms">
                            <label class="ef-terms__label">
                                <div class="ef-terms__check-wrap">
                                    <input type="checkbox" name="agree_terms" id="agreeTerms" class="ef-terms__input"
                                        required {{ old('agree_terms') ? 'checked' : '' }}>
                                    <span class="ef-terms__checkmark">
                                        <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="white"
                                            stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 6L9 17l-5-5" />
                                        </svg>
                                    </span>
                                </div>
                                <span class="ef-terms__text">
                                    Saya menyetujui
                                    <button type="button" class="ef-terms__link" id="openTerms">
                                        Syarat & Ketentuan
                                    </button>
                                    serta
                                    <button type="button" class="ef-terms__link" id="openPrivacy">
                                        Kebijakan Privasi
                                    </button>
                                    Efata Galon
                                </span>
                            </label>
                            @error('agree_terms')
                                <p class="ef-terms__error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="ef-reg__submit" id="submitBtn">
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

    {{-- ── Terms Modal ── --}}
    <div class="ef-modal-overlay" id="termsModal" role="dialog" aria-modal="true" aria-labelledby="termsTitle">
        <div class="ef-modal">
            <div class="ef-modal__pill"></div>
            <div class="ef-modal__header">
                <div class="ef-modal__header-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                        <polyline points="10 9 9 9 8 9" />
                    </svg>
                </div>
                <h2 class="ef-modal__title" id="termsTitle">Syarat & Ketentuan</h2>
                <button class="ef-modal__close" id="closeTerms" aria-label="Tutup">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6L6 18M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="ef-modal__body">
                <div class="ef-modal__section">
                    <h3 class="ef-modal__section-title">1. Layanan</h3>
                    <p>Efata Galon menyediakan layanan pemesanan dan pengiriman air galon premium ke alamat pelanggan di
                        wilayah layanan kami. Kami berhak mengubah, menangguhkan, atau menghentikan layanan
                        sewaktu-waktu dengan pemberitahuan sebelumnya.</p>
                </div>
                <div class="ef-modal__section">
                    <h3 class="ef-modal__section-title">2. Akun Pengguna</h3>
                    <p>Anda bertanggung jawab menjaga kerahasiaan akun dan kata sandi Anda. Informasi yang diberikan
                        saat pendaftaran harus akurat dan terkini. Kami berhak menangguhkan akun yang melanggar
                        ketentuan ini.</p>
                </div>
                <div class="ef-modal__section">
                    <h3 class="ef-modal__section-title">3. Pemesanan & Pembayaran</h3>
                    <p>Setiap pesanan yang telah dikonfirmasi bersifat mengikat. Pembayaran dapat dilakukan secara tunai
                        (COD) saat barang diterima atau melalui transfer bank. Harga dapat berubah sewaktu-waktu tanpa
                        pemberitahuan sebelumnya.</p>
                </div>
                <div class="ef-modal__section">
                    <h3 class="ef-modal__section-title">4. Pengiriman</h3>
                    <p>Pengiriman dilakukan pada hari yang sama atau sesuai jadwal yang disepakati. Estimasi waktu
                        pengiriman bersifat perkiraan dan dapat berubah tergantung kondisi di lapangan. Kami tidak
                        bertanggung jawab atas keterlambatan akibat faktor di luar kendali kami.</p>
                </div>
                <div class="ef-modal__section">
                    <h3 class="ef-modal__section-title">5. Pengembalian & Pembatalan</h3>
                    <p>Pembatalan pesanan dapat dilakukan sebelum kurir berangkat. Pengembalian produk hanya diterima
                        jika terdapat kerusakan atau cacat yang terbukti disebabkan oleh pihak kami. Galon kosong yang
                        dipinjam wajib dikembalikan dalam kondisi baik.</p>
                </div>
                <div class="ef-modal__section">
                    <h3 class="ef-modal__section-title">6. Perubahan Ketentuan</h3>
                    <p>Kami berhak memperbarui Syarat & Ketentuan ini sewaktu-waktu. Perubahan akan berlaku sejak
                        dipublikasikan. Penggunaan layanan secara berkelanjutan dianggap sebagai persetujuan atas
                        perubahan tersebut.</p>
                </div>
            </div>
            <div class="ef-modal__footer">
                <button class="ef-modal__agree-btn" id="agreeFromTerms">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 6L9 17l-5-5" />
                    </svg>
                    Saya Setuju
                </button>
                <button class="ef-modal__cancel-btn" id="closeTerms2">Tutup</button>
            </div>
        </div>
    </div>

    {{-- ── Privacy Modal ── --}}
    <div class="ef-modal-overlay" id="privacyModal" role="dialog" aria-modal="true" aria-labelledby="privacyTitle">
        <div class="ef-modal">
            <div class="ef-modal__pill"></div>
            <div class="ef-modal__header">
                <div class="ef-modal__header-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                </div>
                <h2 class="ef-modal__title" id="privacyTitle">Kebijakan Privasi</h2>
                <button class="ef-modal__close" id="closePrivacy" aria-label="Tutup">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6L6 18M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="ef-modal__body">
                <div class="ef-modal__section">
                    <h3 class="ef-modal__section-title">1. Data yang Kami Kumpulkan</h3>
                    <p>Kami mengumpulkan informasi yang Anda berikan saat mendaftar, yaitu: nama lengkap, username,
                        alamat email, nomor telepon, dan alamat pengiriman. Data ini digunakan semata-mata untuk
                        keperluan operasional layanan.</p>
                </div>
                <div class="ef-modal__section">
                    <h3 class="ef-modal__section-title">2. Penggunaan Data</h3>
                    <p>Data Anda digunakan untuk memproses pesanan, mengirimkan konfirmasi, menghubungi Anda terkait
                        layanan, serta meningkatkan kualitas layanan kami. Kami tidak menggunakan data Anda untuk
                        keperluan iklan pihak ketiga.</p>
                </div>
                <div class="ef-modal__section">
                    <h3 class="ef-modal__section-title">3. Keamanan Data</h3>
                    <p>Kami menerapkan langkah-langkah keamanan teknis dan organisasional untuk melindungi data pribadi
                        Anda dari akses, pengungkapan, perubahan, atau penghancuran yang tidak sah.</p>
                </div>
                <div class="ef-modal__section">
                    <h3 class="ef-modal__section-title">4. Berbagi Data</h3>
                    <p>Kami tidak menjual, menyewakan, atau membagikan data pribadi Anda kepada pihak ketiga tanpa
                        persetujuan Anda, kecuali diwajibkan oleh hukum yang berlaku di Indonesia.</p>
                </div>
                <div class="ef-modal__section">
                    <h3 class="ef-modal__section-title">5. Hak Pengguna</h3>
                    <p>Anda berhak mengakses, memperbarui, atau menghapus data pribadi Anda kapan saja melalui
                        pengaturan akun atau dengan menghubungi kami langsung. Penghapusan akun akan menghapus semua
                        data terkait dari sistem kami.</p>
                </div>
                <div class="ef-modal__section">
                    <h3 class="ef-modal__section-title">6. Cookie</h3>
                    <p>Kami menggunakan cookie untuk menjaga sesi login dan meningkatkan pengalaman pengguna. Anda dapat
                        menonaktifkan cookie melalui pengaturan browser, namun beberapa fitur layanan mungkin tidak
                        berfungsi optimal.</p>
                </div>
            </div>
            <div class="ef-modal__footer">
                <button class="ef-modal__agree-btn" id="agreeFromPrivacy">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 6L9 17l-5-5" />
                    </svg>
                    Saya Mengerti
                </button>
                <button class="ef-modal__cancel-btn" id="closePrivacy2">Tutup</button>
            </div>
        </div>
    </div>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Instrument+Serif:ital@0;1&display=swap");

        /* ── (semua CSS lama tetap sama) ── */

        /* ── Root ──────────────────────────────────────────────────── */
        .ef-reg {
            font-family: "Plus Jakarta Sans", sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            background: #f0f6ff;
            position: relative;
            overflow: hidden;
        }

        .dark .ef-reg {
            background: #0b1120;
        }

        .ef-reg__bg {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .ef-reg__blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
        }

        .ef-reg__blob--1 {
            width: 520px;
            height: 520px;
            background: radial-gradient(circle, #bfdbfe, transparent);
            top: -140px;
            right: -100px;
            opacity: 0.5;
        }

        .ef-reg__blob--2 {
            width: 380px;
            height: 380px;
            background: radial-gradient(circle, #a5f3fc, transparent);
            bottom: -60px;
            left: -80px;
            opacity: 0.38;
        }

        .ef-reg__blob--3 {
            width: 260px;
            height: 260px;
            background: radial-gradient(circle, #c7d2fe, transparent);
            top: 40%;
            left: 30%;
            opacity: 0.22;
        }

        .dark .ef-reg__blob--1 {
            opacity: 0.1;
        }

        .dark .ef-reg__blob--2 {
            opacity: 0.07;
        }

        .dark .ef-reg__blob--3 {
            opacity: 0.05;
        }

        .ef-reg__wrap {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1020px;
            display: grid;
            grid-template-columns: 1fr;
            gap: 32px;
            align-items: start;
        }

        @media (min-width: 900px) {
            .ef-reg__wrap {
                grid-template-columns: 1fr 1.2fr;
                gap: 52px;
                align-items: center;
            }
        }

        .ef-reg__left {
            display: none;
            flex-direction: column;
            gap: 28px;
        }

        @media (min-width: 900px) {
            .ef-reg__left {
                display: flex;
            }
        }

        .ef-reg__brand {
            display: inline-block;
        }

        .ef-reg__brand-img {
            height: 180px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 8px 24px rgba(37, 99, 235, 0.2));
        }

        .ef-reg__left-copy {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .ef-reg__left-title {
            font-family: "Instrument Serif", serif;
            font-size: clamp(1.8rem, 2.4vw, 2.3rem);
            font-weight: 400;
            color: #1e3a5f;
            line-height: 1.2;
        }

        .dark .ef-reg__left-title {
            color: #e2e8f0;
        }

        .ef-reg__left-title em {
            font-style: italic;
            color: #2563eb;
        }

        .dark .ef-reg__left-title em {
            color: #60a5fa;
        }

        .ef-reg__left-sub {
            font-size: 0.86rem;
            color: #64748b;
            line-height: 1.65;
            max-width: 300px;
        }

        .dark .ef-reg__left-sub {
            color: #94a3b8;
        }

        .ef-reg__steps {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .ef-reg__step {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 4px 0;
        }

        .ef-reg__step-num {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2563eb, #06b6d4);
            color: #fff;
            font-size: 0.78rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 3px 10px rgba(37, 99, 235, 0.3);
        }

        .ef-reg__step-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: #1e293b;
        }

        .dark .ef-reg__step-title {
            color: #f1f5f9;
        }

        .ef-reg__step-sub {
            font-size: 0.75rem;
            color: #94a3b8;
            margin-top: 2px;
        }

        .ef-reg__step-line {
            width: 2px;
            height: 18px;
            background: linear-gradient(to bottom, #bfdbfe, #e0f2fe);
            margin-left: 14px;
        }

        .dark .ef-reg__step-line {
            background: linear-gradient(to bottom, rgba(37, 99, 235, 0.3), rgba(6, 182, 212, 0.2));
        }

        .ef-reg__right {
            display: flex;
            justify-content: center;
        }

        .ef-reg__card {
            width: 100%;
            max-width: 480px;
            background: rgba(255, 255, 255, 0.93);
            backdrop-filter: blur(20px) saturate(160%);
            -webkit-backdrop-filter: blur(20px) saturate(160%);
            border: 1px solid rgba(37, 99, 235, 0.1);
            border-radius: 24px;
            padding: 28px 24px;
            box-shadow: 0 8px 40px rgba(37, 99, 235, 0.1), 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .dark .ef-reg__card {
            background: rgba(17, 24, 39, 0.9);
            border-color: rgba(255, 255, 255, 0.07);
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.3);
        }

        @media (min-width: 640px) {
            .ef-reg__card {
                padding: 32px 28px;
            }
        }

        .ef-reg__mobile-logo {
            display: flex;
            justify-content: center;
            margin-bottom: 18px;
        }

        @media (min-width: 900px) {
            .ef-reg__mobile-logo {
                display: none;
            }
        }

        .ef-reg__mobile-logo-img {
            height: 64px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 4px 12px rgba(37, 99, 235, 0.2));
        }

        .ef-reg__card-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .ef-reg__card-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: #1e293b;
            line-height: 1;
            margin-bottom: 6px;
        }

        .dark .ef-reg__card-title {
            color: #f1f5f9;
        }

        .ef-reg__card-sub {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        .ef-reg__form {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .ef-reg__row {
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px;
        }

        @media (min-width: 480px) {
            .ef-reg__row {
                grid-template-columns: 1fr 1fr;
            }
        }

        .ef-field {
            display: flex;
            flex-direction: column;
            gap: 5px;
            min-width: 0;
        }

        .ef-field__label {
            font-size: 0.76rem;
            font-weight: 700;
            color: #475569;
            letter-spacing: 0.02em;
        }

        .dark .ef-field__label {
            color: #94a3b8;
        }

        .ef-field__wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .ef-field__icon {
            position: absolute;
            left: 13px;
            color: #94a3b8;
            pointer-events: none;
            flex-shrink: 0;
        }

        .ef-field__input {
            width: 100%;
            padding: 10px 13px 10px 38px;
            border-radius: 11px;
            border: 1.5px solid rgba(37, 99, 235, 0.15);
            background: #f8fafc;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 0.85rem;
            color: #1e293b;
            outline: none;
            transition: border-color 0.18s, box-shadow 0.18s, background 0.18s;
            min-width: 0;
        }

        .dark .ef-field__input {
            background: #1e293b;
            border-color: rgba(255, 255, 255, 0.1);
            color: #f1f5f9;
        }

        .ef-field__input::placeholder {
            color: #cbd5e1;
        }

        .dark .ef-field__input::placeholder {
            color: #475569;
        }

        .ef-field__input:focus {
            border-color: #2563eb;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .dark .ef-field__input:focus {
            border-color: #60a5fa;
            background: #111827;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.15);
        }

        .ef-field__input--pw {
            padding-right: 40px;
        }

        .ef-field__eye {
            position: absolute;
            right: 11px;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 3px;
            color: #94a3b8;
            display: flex;
            transition: color 0.15s;
        }

        .ef-field__eye:hover {
            color: #2563eb;
        }

        .ef-field__error {
            font-size: 0.73rem;
            color: #ef4444;
            margin-top: 1px;
        }

        .ef-reg__submit {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 0.88rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(37, 99, 235, 0.35);
            transition: box-shadow 0.2s, transform 0.2s, opacity 0.2s;
            margin-top: 6px;
        }

        .ef-reg__submit:hover:not(:disabled) {
            box-shadow: 0 6px 22px rgba(37, 99, 235, 0.45);
            transform: translateY(-1px);
        }

        .ef-reg__submit:active {
            transform: scale(0.98);
        }

        .ef-reg__submit:disabled {
            opacity: 0.55;
            cursor: not-allowed;
            transform: none;
        }

        .ef-reg__login-link {
            text-align: center;
            font-size: 0.8rem;
            color: #94a3b8;
            margin-top: 2px;
        }

        .ef-reg__login-link a {
            color: #2563eb;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.15s;
        }

        .ef-reg__login-link a:hover {
            color: #1d4ed8;
        }

        .dark .ef-reg__login-link a {
            color: #60a5fa;
        }

        /* ── Terms Checkbox ────────────────────────────────────────── */
        .ef-terms {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .ef-terms__label {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            cursor: pointer;
            user-select: none;
        }

        .ef-terms__check-wrap {
            position: relative;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .ef-terms__input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .ef-terms__checkmark {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 18px;
            height: 18px;
            border-radius: 5px;
            border: 1.5px solid rgba(37, 99, 235, 0.3);
            background: #f8fafc;
            transition: background 0.18s, border-color 0.18s, box-shadow 0.18s;
        }

        .ef-terms__checkmark svg {
            opacity: 0;
            transform: scale(0.5);
            transition: opacity 0.15s, transform 0.15s;
        }

        .ef-terms__input:checked~.ef-terms__checkmark {
            background: #2563eb;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        .ef-terms__input:checked~.ef-terms__checkmark svg {
            opacity: 1;
            transform: scale(1);
        }

        .ef-terms__text {
            font-size: 0.78rem;
            color: #64748b;
            line-height: 1.6;
        }

        .dark .ef-terms__text {
            color: #94a3b8;
        }

        .ef-terms__link {
            background: none;
            border: none;
            padding: 0;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 0.78rem;
            font-weight: 700;
            color: #2563eb;
            cursor: pointer;
            text-decoration: underline;
            text-underline-offset: 2px;
            transition: color 0.15s;
        }

        .ef-terms__link:hover {
            color: #1d4ed8;
        }

        .dark .ef-terms__link {
            color: #60a5fa;
        }

        .ef-terms__error {
            font-size: 0.73rem;
            color: #ef4444;
            font-weight: 600;
        }

        /* ── Modal ─────────────────────────────────────────────────── */
        .ef-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            align-items: flex-end;
            justify-content: center;
            padding: 0;
        }

        .ef-modal-overlay.open {
            display: flex;
        }

        .ef-modal {
            width: 100%;
            max-width: 560px;
            background: #fff;
            border-radius: 24px 24px 0 0;
            display: flex;
            flex-direction: column;
            max-height: 85vh;
            box-shadow: 0 -8px 40px rgba(15, 23, 42, 0.2);
            animation: efModalUp .3s cubic-bezier(.22, 1, .36, 1);
        }

        .dark .ef-modal {
            background: #0f172a;
        }

        @keyframes efModalUp {
            from {
                transform: translateY(60px);
                opacity: 0;
            }

            to {
                transform: none;
                opacity: 1;
            }
        }

        .ef-modal__pill {
            width: 36px;
            height: 4px;
            border-radius: 99px;
            background: #e2e8f0;
            margin: 14px auto 0;
            flex-shrink: 0;
        }

        .dark .ef-modal__pill {
            background: #334155;
        }

        .ef-modal__header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 16px 20px 14px;
            border-bottom: 1px solid rgba(37, 99, 235, 0.08);
            flex-shrink: 0;
        }

        .dark .ef-modal__header {
            border-bottom-color: rgba(255, 255, 255, 0.07);
        }

        .ef-modal__header-icon {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            background: #eff6ff;
            border: 1px solid rgba(37, 99, 235, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            flex-shrink: 0;
        }

        .dark .ef-modal__header-icon {
            background: rgba(37, 99, 235, 0.12);
            border-color: rgba(37, 99, 235, 0.25);
            color: #60a5fa;
        }

        .ef-modal__title {
            flex: 1;
            font-size: 0.95rem;
            font-weight: 800;
            color: #1e293b;
        }

        .dark .ef-modal__title {
            color: #f1f5f9;
        }

        .ef-modal__close {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: #f1f5f9;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            cursor: pointer;
            flex-shrink: 0;
            transition: background 0.15s, color 0.15s;
        }

        .ef-modal__close:hover {
            background: #e2e8f0;
            color: #1e293b;
        }

        .dark .ef-modal__close {
            background: rgba(255, 255, 255, 0.07);
            color: #94a3b8;
        }

        .dark .ef-modal__close:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #f1f5f9;
        }

        .ef-modal__body {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 18px;
            overscroll-behavior: contain;
        }

        .ef-modal__body::-webkit-scrollbar {
            width: 4px;
        }

        .ef-modal__body::-webkit-scrollbar-track {
            background: transparent;
        }

        .ef-modal__body::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 99px;
        }

        .dark .ef-modal__body::-webkit-scrollbar-thumb {
            background: #334155;
        }

        .ef-modal__section {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .ef-modal__section-title {
            font-size: 0.82rem;
            font-weight: 800;
            color: #1e293b;
        }

        .dark .ef-modal__section-title {
            color: #f1f5f9;
        }

        .ef-modal__section p {
            font-size: 0.8rem;
            color: #64748b;
            line-height: 1.7;
        }

        .dark .ef-modal__section p {
            color: #94a3b8;
        }

        .ef-modal__footer {
            padding: 14px 20px max(14px, env(safe-area-inset-bottom));
            border-top: 1px solid rgba(37, 99, 235, 0.08);
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex-shrink: 0;
        }

        .dark .ef-modal__footer {
            border-top-color: rgba(255, 255, 255, 0.07);
        }

        .ef-modal__agree-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 0.86rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
            transition: box-shadow 0.2s, transform 0.15s;
        }

        .ef-modal__agree-btn:hover {
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.45);
            transform: translateY(-1px);
        }

        .ef-modal__cancel-btn {
            width: 100%;
            padding: 12px;
            background: #f1f5f9;
            border: none;
            border-radius: 12px;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-size: 0.86rem;
            font-weight: 700;
            color: #475569;
            cursor: pointer;
            transition: background 0.15s;
        }

        .ef-modal__cancel-btn:hover {
            background: #e2e8f0;
        }

        .dark .ef-modal__cancel-btn {
            background: rgba(255, 255, 255, 0.07);
            color: #94a3b8;
        }

        .dark .ef-modal__cancel-btn:hover {
            background: rgba(255, 255, 255, 0.12);
        }

        @keyframes efSpin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>

    <script>
        (function () {

            // ── Modal helpers ─────────────────────────────────────────
            function openModal(id) {
                document.getElementById(id).classList.add('open');
                document.body.style.overflow = 'hidden';
            }

            function closeModal(id) {
                const el = document.getElementById(id);
                el.querySelector('.ef-modal').style.animation = 'efModalDown .22s cubic-bezier(.4,0,1,1) forwards';

                // inject keyframe sekali saja
                if (!document.getElementById('efModalDownKf')) {
                    const s = document.createElement('style');
                    s.id = 'efModalDownKf';
                    s.textContent = '@keyframes efModalDown{to{transform:translateY(60px);opacity:0}}';
                    document.head.appendChild(s);
                }

                setTimeout(() => {
                    el.classList.remove('open');
                    el.querySelector('.ef-modal').style.animation = '';
                    document.body.style.overflow = '';
                }, 220);
            }

            // ── Terms modal ───────────────────────────────────────────
            document.getElementById('openTerms').addEventListener('click', () => openModal('termsModal'));
            document.getElementById('closeTerms').addEventListener('click', () => closeModal('termsModal'));
            document.getElementById('closeTerms2').addEventListener('click', () => closeModal('termsModal'));
            document.getElementById('agreeFromTerms').addEventListener('click', () => {
                document.getElementById('agreeTerms').checked = true;
                closeModal('termsModal');
            });

            // ── Privacy modal ─────────────────────────────────────────
            document.getElementById('openPrivacy').addEventListener('click', () => openModal('privacyModal'));
            document.getElementById('closePrivacy').addEventListener('click', () => closeModal('privacyModal'));
            document.getElementById('closePrivacy2').addEventListener('click', () => closeModal('privacyModal'));
            document.getElementById('agreeFromPrivacy').addEventListener('click', () => {
                document.getElementById('agreeTerms').checked = true;
                closeModal('privacyModal');
            });

            // Klik backdrop untuk tutup
            ['termsModal', 'privacyModal'].forEach(id => {
                document.getElementById(id).addEventListener('click', e => {
                    if (e.target.id === id) closeModal(id);
                });
            });

            // Escape untuk tutup
            document.addEventListener('keydown', e => {
                if (e.key !== 'Escape') return;
                ['termsModal', 'privacyModal'].forEach(id => {
                    if (document.getElementById(id).classList.contains('open')) closeModal(id);
                });
            });

            // ── Submit loading state ──────────────────────────────────
            document.getElementById('registerForm').addEventListener('submit', function () {
                const btn = document.getElementById('submitBtn');
                btn.disabled = true;
                btn.innerHTML = `
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5" stroke-linecap="round"
                        style="animation:efSpin .7s linear infinite;flex-shrink:0">
                        <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83
                                 M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                    </svg>
                    Mendaftarkan...`;
            });

        })();
    </script>

</x-guest-layout>