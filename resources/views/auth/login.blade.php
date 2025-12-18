<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="min-h-screen flex items-center justify-center p-4 bg-gray-50 dark:bg-gray-900">
        <div class="w-full max-w-5xl grid lg:grid-cols-2 gap-8 lg:gap-16 items-center">

            <!-- Logo di kiri (desktop) -->
            <div class="hidden lg:flex flex-col items-center justify-center">
                <a href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('assets/icons/Frame 44.png') }}" alt="Brand Logo"
                        class="h-80 w-auto object-contain drop-shadow-lg">
                </a>
                <p class="mt-8 text-center text-gray-600 dark:text-gray-300 text-lg font-medium">
                    Selamat datang kembali!
                </p>
            </div>

            <!-- Logo kecil di atas form (mobile) --> 
            {{-- <div class="flex lg:hidden flex-col items-center mb-8">
                <a href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('assets/icons/Frame 44.png') }}" alt="Brand Logo"
                        class="h-48 w-auto object-contain">
                </a>
            </div> --}}

            <!-- Form Login -->
            <div class="w-full max-w-md mx-auto">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 lg:p-10">
                    <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-8">
                        Masuk ke Akun
                    </h2>

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="id_user" :value="__('Email atau Username')" />
                            <x-text-input id="id_user" name="id_user" type="text" :value="old('id_user')" required
                                autofocus autocomplete="username" class="mt-1 w-full" />
                            <x-input-error :messages="$errors->get('id_user')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" name="password" type="password" required
                                autocomplete="current-password" class="mt-1 w-full" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between text-sm">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember"
                                    class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="ml-2 text-gray-600 dark:text-gray-300">{{ __('Ingat saya') }}</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-200 font-medium">
                                    {{ __('Lupa password?') }}
                                </a>
                            @endif
                        </div>

                        <button type="submit"
                            class="w-full bg-gogalon-primary hover:bg-gogalon-secondary text-white font-semibold py-3 rounded-lg transition duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            {{ __('Masuk') }}
                        </button>

                        <!-- Google Login -->
                        <div class="mt-6">
                            <a href="/auth/google/redirect"
                                class="w-full flex items-center justify-center gap-3 py-3 px-4 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition shadow-sm">
                                <svg class="w-6 h-6" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="#EA4335"
                                        d="M24 9.5c3.5 0 6.5 1.2 8.9 3.6l6.6-6.6C35.6 2.4 30.2 0 24 0 14.6 0 6.6 5.4 2.6 13.2l7.7 6C12.3 12.2 17.7 9.5 24 9.5z" />
                                    <path fill="#34A853"
                                        d="M46.1 24.6c0-1.6-.1-3.1-.4-4.6H24v9h12.4c-.6 3-2.4 5.5-5 7.2l7.7 6c4.5-4.2 7.1-10.4 7.1-17.6z" />
                                    <path fill="#4A90E2"
                                        d="M24 48c6.5 0 12-2.1 16-5.8l-7.7-6c-2.1 1.4-4.8 2.2-8.3 2.2-6.4 0-11.8-4.3-13.7-10.1l-7.7 6C6.6 42.6 14.6 48 24 48z" />
                                    <path fill="#FBBC05"
                                        d="M10.3 28.3c-.5-1.4-.8-3-.8-4.6s.3-3.2.8-4.6l-7.7-6C.9 15.9 0 19.4 0 23.7s.9 7.8 2.6 11.2l7.7-6z" />
                                </svg>
                                <span class="font-medium">Masuk dengan Google</span>
                            </a>
                        </div>

                        <p class="text-center text-sm text-gray-600 dark:text-gray-400 mt-8">
                            {{ __('Belum punya akun?') }}
                            <a href="{{ route('register') }}"
                                class="font-semibold text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-200">
                                {{ __('Daftar di sini') }}
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
