{{-- <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div
            class="flex flex-col items-center justify-center lg:flex-row h-screen space-y-8 lg:space-y-0 lg:space-x-12 p-4">
            <div class="shrink-0 flex flex-col items-center justify-center">
                <a href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('assets/icons/Frame 44.png') }}" alt="Brand Logo" class="h-40 w-auto lg:h-80">
                </a>
            </div>

            <!-- Name -->
            <div class="w-full max-w-sm">
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                        required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Username -->
                <div class="mt-4">
                    <x-input-label for="username" :value="__('Username')" />
                    <x-text-input id="username" class="block mt-1 w-full" type="text" name="username"
                        :value="old('username')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4 mb-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>


                    <button
                        class="bg-gogalon-primary text-white rounded-lg px-4 py-2 font-semibold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center gap-2 ml-4">
                        {{ _('Register') }}
                    </button>

                    {{-- <x-primary-button class="ms-4">
                        {{ __('Register') }}
                    </x-primary-button> --}}
{{--
                </div>
            </div>
        </div>
    </form> --}}
{{--
</x-guest-layout> --}}


<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center p-4 bg-gray-50 dark:bg-gray-900">
        <div class="w-full max-w-5xl grid lg:grid-cols-2 gap-8 lg:gap-16 items-center">

            <!-- Logo di kiri (desktop) -->
            <div class="hidden lg:flex flex-col items-center justify-center">
                <a href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('assets/icons/Frame 44.png') }}" alt="Brand Logo"
                        class="h-80 w-auto object-contain drop-shadow-lg">
                </a>
                <p class="mt-8 text-center text-gray-600 dark:text-gray-300 text-lg font-medium">
                    Bergabunglah bersama kami!
                </p>
            </div>

            <!-- Logo kecil di atas form (mobile) -->
            {{-- <div class="flex lg:hidden flex-col items-center mb-8">
                <a href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('assets/icons/Frame 44.png') }}" alt="Brand Logo"
                        class="h-48 w-auto object-contain">
                </a>
            </div> --}}

            <!-- Form Register -->
            <div class="w-full max-w-md mx-auto">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 lg:p-10">
                    <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-8">
                        Buat Akun Baru
                    </h2>

                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Nama Lengkap')" />
                            <x-text-input id="name" name="name" type="text" :value="old('name')" required
                                autofocus autocomplete="name" class="mt-1 w-full" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="username" :value="__('Username')" />
                            <x-text-input id="username" name="username" type="text" :value="old('username')" required
                                class="mt-1 w-full" />
                            <x-input-error :messages="$errors->get('username')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" :value="old('email')" required
                                class="mt-1 w-full" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" name="password" type="password" required
                                autocomplete="new-password" class="mt-1 w-full" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                                required autocomplete="new-password" class="mt-1 w-full" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <button type="submit"
                            class="w-full bg-gogalon-primary hover:bg-gogalon-secondary text-white font-semibold py-3 rounded-lg transition duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            {{ __('Daftar') }}
                        </button>

                        <p class="text-center text-sm text-gray-600 dark:text-gray-400 mt-8">
                            {{ __('Sudah punya akun?') }}
                            <a href="{{ route('login') }}"
                                class="font-semibold text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-200">
                                {{ __('Masuk di sini') }}
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
