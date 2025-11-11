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
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                        :value="old('name')" required autofocus autocomplete="name" />
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
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" required autocomplete="username" />
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
                {{-- </div>
            </div>
        </div>
    </form> --}}
{{-- </x-guest-layout> --}} 
