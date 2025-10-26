<div>
    <h1>Ini halaman Home Kurir</h1>

    <x-responsive-nav-link :href="route('profile.edit')">
        {{ __('Profile') }}
    </x-responsive-nav-link>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
            {{ __('Log Out') }}
        </x-dropdown-link>
    </form>
</div>