<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="w-full h-full max-w-md mx-auto bg-white dark:bg-gray-900 rounded-2xl shadow-sm px-6 py-8 mb-6">

        <div class="shrink-0 flex flex-col items-center justify-center mb-6">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('assets/icons/Frame 44.png') }}" alt="Brand Logo" class="h-60 w-auto">
            </a>
        </div>

        <!-- Google Sign In -->
        <div class="mb-6">
            <a href="/auth/google/redirect"
                class="flex items-center justify-center gap-2 w-full py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                    <path fill="#EA4335"
                        d="M24 9.5c3.5 0 6.5 1.2 8.9 3.6l6.6-6.6C35.6 2.4 30.2 0 24 0 14.6 0 6.6 5.4 2.6 13.2l7.7 6C12.3 12.2 17.7 9.5 24 9.5z" />
                    <path fill="#34A853"
                        d="M46.1 24.6c0-1.6-.1-3.1-.4-4.6H24v9h12.4c-.6 3-2.4 5.5-5 7.2l7.7 6c4.5-4.2 7.1-10.4 7.1-17.6z" />
                    <path fill="#4A90E2"
                        d="M24 48c6.5 0 12-2.1 16-5.8l-7.7-6c-2.1 1.4-4.8 2.2-8.3 2.2-6.4 0-11.8-4.3-13.7-10.1l-7.7 6C6.6 42.6 14.6 48 24 48z" />
                    <path fill="#FBBC05"
                        d="M10.3 28.3c-.5-1.4-.8-3-.8-4.6s.3-3.2.8-4.6l-7.7-6C.9 15.9 0 19.4 0 23.7s.9 7.8 2.6 11.2l7.7-6z" />
                </svg>
                <span>Sign in with Google</span>
            </a>
        </div>

        <div class="relative mb-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300 dark:border-gray-700"></div>
            </div>
            <div class="relative flex justify-center text-xs uppercase">
                <span class="bg-white dark:bg-gray-900 px-2 text-gray-500">
                    or continue with email
                </span>
            </div>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email or Username -->
            <div class="mb-4">
                <x-input-label for="id_user" :value="__('Email or Username')" />
                <x-text-input id="id_user" class="block mt-1 w-full" type="text" name="id_user" :value="old('id_user')"
                    required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('id_user')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between mb-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-300">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <!-- Submit -->
            <button
                class="w-full justify-center bg-gogalon-primary hover:bg-gogalon-secondary mb-4 px-4 py-2 rounded-lg text-white font-semibold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center gap-2"
                type="submit">
                {{ __('Log in') }}
            </button>
            {{-- <x-primary-button class="w-full justify-center bg-gogalon-primary hover:bg-gogalon-secondary">
                {{ __('Log in') }}
            </x-primary-button> --}}
        </form>

        <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-6">
            {{ __("Don't have an account?") }}
            <a href="{{ route('register') }}"
                class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                {{ __('Register here') }}
            </a>
        </p>
    </div>
</x-guest-layout>