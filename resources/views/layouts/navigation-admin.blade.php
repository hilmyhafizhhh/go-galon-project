<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-[9999]">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Logo + Nav Links -->
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}">
                        <img src="{{ asset('assets/icons/logo.svg') }}" alt="Brand Logo" class="h-10 w-auto">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:space-x-8 sm:ms-10">
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        🏠 {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('admin.orders')" :active="request()->routeIs('admin.orders*')">
                        🧾 {{ __('Pesanan') }}
                    </x-nav-link>

                    <x-nav-link :href="route('admin.couriers.index')" :active="request()->routeIs('admin.couriers*')">
                        🚴 {{ __('Kurir') }}
                    </x-nav-link>

                    <x-nav-link :href="route('admin.inventory')" :active="request()->routeIs('admin.inventory*')">
                        📦 {{ __('Inventory') }}
                    </x-nav-link>

                    <x-nav-link :href="route('admin.reports')" :active="request()->routeIs('admin.reports*')">
                        📊 {{ __('Laporan') }}
                    </x-nav-link>

                    <x-nav-link :href="route('admin.settings')" :active="request()->routeIs('admin.settings*')">
                        ⚙ {{ __('Pengaturan') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:text-gray-900 focus:outline-none transition ease-in-out duration-150">

                            <div>{{ Auth::user()->name }}</div>

                            <svg class="fill-current h-4 w-4 ms-1" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Hamburger Menu -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Responsive Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">

        <!-- User Info -->
        <div class="pt-4 pb-3 border-b border-gray-200 px-4">
            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
        </div>

        <!-- Navigation (mobile) -->
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                🏠 {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('admin.orders')" :active="request()->routeIs('admin.orders*')">
                🧾 {{ __('Pesanan') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('admin.couriers.index')"
                :active="request()->routeIs('admin.couriers*')">
                🚴 {{ __('Kurir') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('admin.inventory')" :active="request()->routeIs('admin.inventory*')">
                📦 {{ __('Inventory') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('admin.reports')" :active="request()->routeIs('admin.reports*')">
                📊 {{ __('Laporan') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('admin.settings')" :active="request()->routeIs('admin.settings*')">
                ⚙ {{ __('Pengaturan') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('profile.edit')">
                {{ __('Profile') }}
            </x-responsive-nav-link>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>