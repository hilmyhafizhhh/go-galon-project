{{-- <x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div x-data="{ showLogin: true }" 
        class="flex flex-col items-center justify-center lg:flex-row h-screen space-y-8 lg:space-y-0 lg:space-x-12 p-4 overflow-hidden">
        
        <div class="shrink-0 flex flex-col items-center justify-center">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('assets/icons/Frame 44.png') }}" alt="Brand Logo" class="h-48 w-auto lg:h-80">
            </a>
        </div>

        <div class="w-full max-w-sm relative h-full"> 
            
            <div x-show="showLogin"
                 x-transition:enter="transition ease-out duration-500 transform" 
                 x-transition:enter-start="opacity-0 -translate-x-full" 
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-500 absolute top-0 left-0 w-full"
                 x-transition:leave-end="opacity-0 translate-x-full" 
                 class="p-6"> 
                 
                <div class="mb-6">
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

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-4">
                        <x-input-label for="id_user" :value="__('Email or Username')" />
                        <x-text-input id="id_user" class="block mt-1 w-full" type="text" name="id_user"
                            :value="old('id_user')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('id_user')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between mb-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                name="remember">
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-300">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>

                    <button
                        class="w-full justify-center bg-gogalon-primary hover:bg-gogalon-secondary mb-4 px-4 py-2 rounded-lg text-white font-semibold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center gap-2"
                        type="submit">
                        {{ __('Log in') }}
                    </button>
                </form>

                <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-6 ">
                    {{ __("Don't have an account?") }}
                    <a href="#" **@click.prevent="showLogin = false"**
                        class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                        {{ __('Register here') }}
                    </a>
                </p>
            </div>

            <div x-show="!showLogin"
                 x-transition:enter="transition ease-out duration-500 transform" 
                 x-transition:enter-start="opacity-0 translate-x-full" 
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-500 absolute top-0 left-0 w-full"
                 x-transition:leave-end="opacity-0 -translate-x-full" 
                 class="**absolute top-0 left-0 w-full p-6**">
                 
                 <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="username" :value="__('Username')" />
                        <x-text-input id="username" class="block mt-1 w-full" type="text" name="username"
                            :value="old('username')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password_reg" :value="__('Password')" />
                        <x-text-input id="password_reg" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4 mb-4">
                        
                        <button
                            class="bg-gogalon-primary text-white rounded-lg px-4 py-2 font-semibold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center gap-2 ml-4">
                            {{ _('Register') }}
                        </button>
                    </div>
                </form>

                 <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-6 ">
                    {{ __("Already have an account?") }}
                    <a href="#" **@click.prevent="showLogin = true"**
                        class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                        {{ __('Log in here') }}
                    </a>
                </p>
            </div>
            
        </div>
    </div>
</x-guest-layout> --}}