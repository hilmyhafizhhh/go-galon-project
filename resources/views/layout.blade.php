<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoGalon Admin</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md">
            <div class="p-4 flex items-center space-x-2 border-b">
                <img src="{{ asset('assets/icons/logo.svg') }}" class="w-1000 h-1000" alt="GoGalon">
                {{-- <h1 class="font-bold text-lg text-blue-700">GoGalon</h1> --}}
            </div>
            <nav class="p-4">
                <ul class="space-y-2">
                    <li><a href="{{ route('admin.dashboard') }}" class="block p-2 rounded hover:bg-blue-100 text-blue-600 font-semibold">🏠 Dashboard</a></li>
                    <li><a href="{{ route('admin.orders') }}" class="block p-2 rounded hover:bg-blue-100 text-blue-600 font-semibold">🧾 Pesanan</a></li>
                    <li><a href="{{ route('admin.couriers.index') }}" class="block p-2 rounded hover:bg-blue-100 text-blue-600 font-semibold">🚴 Kurir</a></li>
                    <li><a href="{{ route('admin.inventory.index') }}" class="block p-2 rounded hover:bg-blue-100 text-blue-600 font-semibold">📦 Inventory</a></li>
                    <li><a href="{{ route('admin.reports') }}" class="block p-2 rounded hover:bg-blue-100 text-blue-600 font-semibold">📊 Laporan</a></li>
                    <li><a href="{{ route('admin.settings') }}" class="block p-2 rounded hover:bg-blue-100 text-blue-600 font-semibold">⚙️ Pengaturan</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            
            <!-- ✅ Top Navigation Bar -->
            <header class="bg-white border-b border-gray-200 px-6 py-3 flex justify-between items-center shadow-sm sticky top-0 z-50">
                <h1 class="text-lg font-semibold text-gray-700">Dashboard Admin</h1>

                <!-- ✅ User Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center space-x-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-md transition duration-150 ease-in-out">
                        {{-- Avatar --}}
                        <img class="h-8 w-8 rounded-full object-cover"
                            src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                            alt="{{ Auth::user()->name }}">
                        <span class="text-sm font-medium">{{ Auth::user()->name }}</span>

                        <!-- Icon panah -->
                        <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg py-2 z-50">
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            ✏️ Edit Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                🚪 Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- ✅ Page Content -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Alpine.js for dropdown --}}
    {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}

</body>
</html>
