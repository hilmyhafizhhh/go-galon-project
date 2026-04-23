<nav x-data="{ open: false }" class="ef-nav">

    {{-- ── Backdrop blur bar ── --}}
    <div class="ef-nav__inner">
        <div class="ef-nav__container">

            {{-- ════ LEFT: Logo + Links ════ --}}
            <div class="ef-nav__left">

                {{-- Logo --}}
                <a href="{{ route('customer.home') }}" class="ef-nav__logo">
                    <img src="{{ asset('assets/icons/logo.svg') }}" alt="Efata" class="ef-nav__logo-img">
                </a>

                {{-- Desktop Nav Links --}}
                <div class="ef-nav__links">
                    <a href="{{ route('customer.home') }}"
                        class="ef-nav__link {{ request()->routeIs('customer.home*') ? 'ef-nav__link--active' : '' }}">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.5z" />
                            <path d="M9 21V12h6v9" />
                        </svg>
                        Home
                    </a>

                    <a href="{{ route('customer.order') }}"
                        class="ef-nav__link {{ request()->routeIs('customer.order*') ? 'ef-nav__link--active' : '' }}">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                            <rect x="9" y="3" width="6" height="4" rx="1" />
                            <path d="M9 12h6M9 16h4" />
                        </svg>
                        Pesanan
                    </a>

                    <a href="{{ route('customer.chat') }}"
                        class="ef-nav__link {{ request()->routeIs('customer.chat*') ? 'ef-nav__link--active' : '' }}">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                        </svg>
                        Chat
                    </a>
                </div>
            </div>

            {{-- ════ RIGHT: Cart + User (Desktop) ════ --}}
            <div class="ef-nav__right">

                {{-- Cart --}}
                <a href="{{ route('customer.cart') }}" class="ef-nav__cart cart-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1" />
                        <circle cx="20" cy="21" r="1" />
                        <path d="M1 1h4l2.68 13.39A2 2 0 009.66 16h9.72a2 2 0 001.99-1.61L23 6H6" />
                    </svg>
                    @if ($cartCount > 0)
                        <span class="cart-count ef-nav__cart-badge">{{ $cartCount }}</span>
                    @endif
                </a>

                {{-- User Dropdown --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="ef-nav__user-btn">
                            <div class="ef-nav__avatar">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="ef-nav__username">{{ Auth::user()->name }}</span>
                            <svg class="ef-nav__chevron" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" style="display:inline;margin-right:6px;vertical-align:middle">
                                    <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" />
                                    <polyline points="16 17 21 12 16 7" />
                                    <line x1="21" y1="12" x2="9" y2="12" />
                                </svg>
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- ════ MOBILE: Cart + Hamburger ════ --}}
            <div class="ef-nav__mobile-actions">

                <a href="{{ route('customer.cart') }}" class="ef-nav__cart cart-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1" />
                        <circle cx="20" cy="21" r="1" />
                        <path d="M1 1h4l2.68 13.39A2 2 0 009.66 16h9.72a2 2 0 001.99-1.61L23 6H6" />
                    </svg>
                    @if ($cartCount > 0)
                        <span class="cart-count ef-nav__cart-badge">{{ $cartCount }}</span>
                    @endif
                </a>

                <button @click="open = !open" class="ef-nav__hamburger" :aria-expanded="open.toString()">
                    <svg class="ef-nav__ham-icon" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'block': !open }" class="block" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'block': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    {{-- ════ MOBILE DRAWER ════ --}}
    <div x-show="open" x-transition:enter="ef-drawer-enter" x-transition:enter-start="ef-drawer-enter-start"
        x-transition:enter-end="ef-drawer-enter-end" x-transition:leave="ef-drawer-leave"
        x-transition:leave-start="ef-drawer-leave-start" x-transition:leave-end="ef-drawer-leave-end"
        class="ef-drawer sm:hidden">

        {{-- User Info --}}
        <div class="ef-drawer__user">
            <div class="ef-drawer__avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div>
                <p class="ef-drawer__name">{{ Auth::user()->name }}</p>
                <p class="ef-drawer__email">{{ Auth::user()->email }}</p>
            </div>
        </div>

        {{-- Nav Links --}}
        @role('customer')
        <nav class="ef-drawer__nav">
            <a href="{{ route('customer.home') }}"
                class="ef-drawer__link {{ request()->routeIs('customer.home*') ? 'ef-drawer__link--active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.5z" />
                    <path d="M9 21V12h6v9" />
                </svg>
                Home
            </a>

            <a href="{{ route('customer.order') }}"
                class="ef-drawer__link {{ request()->routeIs('customer.order*') ? 'ef-drawer__link--active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                    <rect x="9" y="3" width="6" height="4" rx="1" />
                    <path d="M9 12h6M9 16h4" />
                </svg>
                Pesanan
            </a>

            <a href="{{ route('customer.chat') }}"
                class="ef-drawer__link {{ request()->routeIs('customer.chat*') ? 'ef-drawer__link--active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                </svg>
                Chat
            </a>

            <div class="ef-drawer__divider"></div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="ef-drawer__link ef-drawer__link--logout">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                    Log Out
                </button>
            </form>
        </nav>
        @endrole
    </div>

</nav>