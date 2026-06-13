<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GoGalon Admin</title>
    @vite('resources/css/app.css')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #f3f4f6;
        }

        /* ===========================
           LAYOUT WRAPPER
        =========================== */
        .app-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ===========================
           SIDEBAR
        =========================== */
        .sidebar {
            width: 240px;
            min-height: 100vh;
            background: #1e293b;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 300;
            transition: transform 0.28s cubic-bezier(.4, 0, .2, 1);
            box-shadow: 4px 0 20px rgba(0, 0, 0, .15);
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            min-height: 64px;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .sidebar-brand img {
            height: 34px;
            width: auto;
        }

        .sidebar-close {
            display: none;
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 4px;
            border-radius: 6px;
            transition: color .2s;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
        }

        .sidebar-close:hover {
            color: #fff;
        }

        .sidebar-nav {
            flex: 1;
            padding: 12px 10px;
            display: flex;
            flex-direction: column;
            gap: 2px;
            overflow-y: auto;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 10px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: background .2s, color .2s;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, .07);
            color: #e2e8f0;
        }

        .nav-item.active {
            background: #3b82f6;
            color: #fff;
        }

        .nav-icon {
            font-size: 16px;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-footer {
            padding: 14px 16px;
            border-top: 1px solid rgba(255, 255, 255, .08);
        }

        .admin-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            overflow: hidden;
        }

        .admin-avatar-img {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
            border: 2px solid rgba(255, 255, 255, .15);
        }

        .admin-name {
            font-size: 13px;
            font-weight: 600;
            color: #e2e8f0;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .admin-role {
            font-size: 11px;
            color: #64748b;
            margin: 2px 0 0;
        }

        /* ===========================
           OVERLAY
        =========================== */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .45);
            z-index: 299;
            backdrop-filter: blur(2px);
        }

        .sidebar-overlay.open {
            display: block;
        }

        /* ===========================
           MAIN CONTENT
        =========================== */
        .main-content {
            flex: 1;
            margin-left: 240px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin-left .28s cubic-bezier(.4, 0, .2, 1);
        }

        /* ===========================
           TOPBAR
        =========================== */
        .topbar {
            background: #fff;
            height: 64px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 20px;
            border-bottom: 1px solid #e5e7eb;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .05);
        }

        .hamburger-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: #374151;
            padding: 6px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            transition: background .2s;
            flex-shrink: 0;
        }

        .hamburger-btn:hover {
            background: #f3f4f6;
        }

        .topbar-title {
            flex: 1;
            font-size: 15px;
            font-weight: 600;
            color: #1f2937;
        }

        /* ===========================
           PAGE CONTENT
        =========================== */
        .page-content {
            flex: 1;
            padding: 24px;
        }

        /* ===========================
           GLOBAL TOAST
        =========================== */
        #ef-toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .ef-toast {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 500;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .12);
            transform: translateX(120%);
            transition: transform .35s cubic-bezier(.4, 0, .2, 1);
            max-width: 320px;
        }

        .ef-toast--show {
            transform: translateX(0);
        }

        .ef-toast--success {
            background: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .ef-toast--error {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        /* ===========================
           RESPONSIVE: TABLET (<=1024px)
        =========================== */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-close {
                display: flex;
            }

            .main-content {
                margin-left: 0;
            }
        }

        /* ===========================
           RESPONSIVE: MOBILE (<=640px)
        =========================== */
        @media (max-width: 640px) {
            .page-content {
                padding: 14px;
            }

            .topbar {
                padding: 0 12px;
            }
        }
    </style>
</head>

<body>

    <div class="app-wrapper">

        {{-- OVERLAY (klik untuk tutup sidebar di mobile) --}}
        <div id="sidebarOverlay" class="sidebar-overlay" onclick="closeSidebar()"></div>

        {{-- =====================
         SIDEBAR
    ===================== --}}
        <aside id="sidebar" class="sidebar">

            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                    <img src="{{ asset('assets/icons/logo.svg') }}" alt="GoGalon">
                </a>
                <button class="sidebar-close" onclick="closeSidebar()" aria-label="Tutup menu">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 6L6 18M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">🏠</span> Dashboard
                </a>
                <a href="{{ route('admin.orders') }}"
                    class="nav-item {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                    <span class="nav-icon">🧾</span> Pesanan
                </a>
                <a href="{{ route('admin.couriers.index') }}"
                    class="nav-item {{ request()->routeIs('admin.couriers*') ? 'active' : '' }}">
                    <span class="nav-icon">🚴</span> Kurir
                </a>
                <a href="{{ route('admin.inventory.index') }}"
                    class="nav-item {{ request()->routeIs('admin.inventory*') ? 'active' : '' }}">
                    <span class="nav-icon">📦</span> Inventory
                </a>
                <a href="{{ route('admin.reports') }}"
                    class="nav-item {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                    <span class="nav-icon">📊</span> Laporan
                </a>
                <a href="{{ route('admin.settings') }}"
                    class="nav-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                    <span class="nav-icon">⚙️</span> Pengaturan
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="admin-badge">
                    <img class="admin-avatar-img"
                        src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=3b82f6&color=fff' }}"
                        alt="{{ Auth::user()->name }}">
                    <div style="overflow:hidden;min-width:0">
                        <p class="admin-name">{{ Auth::user()->name }}</p>
                        <p class="admin-role">Administrator</p>
                    </div>
                </div>
            </div>

        </aside>

        {{-- =====================
         MAIN CONTENT
    ===================== --}}
        <div class="main-content" id="mainContent">

            {{-- TOPBAR --}}
            <header class="topbar">

                {{-- Hamburger --}}
                <button class="hamburger-btn" onclick="toggleSidebar()" aria-label="Toggle menu">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <line x1="3" y1="6" x2="21" y2="6" />
                        <line x1="3" y1="12" x2="21" y2="12" />
                        <line x1="3" y1="18" x2="21" y2="18" />
                    </svg>
                </button>

                {{-- Judul halaman (tiap view bisa override via @section('page-title')) --}}
                <div class="topbar-title">@yield('page-title', 'GoGalon Admin')</div>

                {{-- User dropdown --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-lg transition text-sm font-medium">
                        <img class="h-7 w-7 rounded-full object-cover"
                            src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=3b82f6&color=fff' }}"
                            alt="{{ Auth::user()->name }}">
                        <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" x-cloak @click.away="open = false"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-xl shadow-lg py-2 z-50">
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            ✏️ Edit Profile
                        </a>
                        <hr class="my-1 border-gray-100">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                🚪 Logout
                            </button>
                        </form>
                    </div>
                </div>

            </header>

            {{-- PAGE CONTENT --}}
            <main class="page-content">
                @yield('content')
            </main>

        </div>{{-- end main-content --}}
    </div>{{-- end app-wrapper --}}

    <div id="ef-toast-container"></div>

    <script>
        // ===========================
        // SIDEBAR TOGGLE
        // ===========================
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('open');
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').classList.remove('open');
        }

        window.addEventListener('resize', function() {
            if (window.innerWidth > 1024) closeSidebar();
        });

        // ===========================
        // GLOBAL TOAST
        // ===========================
        function showToast(message, type = 'success') {
            const container = document.getElementById('ef-toast-container');
            const t = document.createElement('div');
            t.className = `ef-toast ef-toast--${type}`;
            const icon = type === 'success' ?
                `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>` :
                `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>`;
            t.innerHTML = `${icon}<span>${message}</span>`;
            container.prepend(t);
            requestAnimationFrame(() => t.classList.add('ef-toast--show'));
            setTimeout(() => {
                t.classList.remove('ef-toast--show');
                setTimeout(() => t.remove(), 400);
            }, 2500);
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>
