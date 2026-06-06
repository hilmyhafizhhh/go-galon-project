<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @auth
            @if (Auth::user()->hasRole('customer'))
                @include('layouts.navigation-customer')
            @elseif (Auth::user()->hasRole('admin'))
                @include('layouts.navigation-admin')
            @elseif (Auth::user()->hasRole('courier'))
                @include('layouts.navigation-courier')
            @endif
        @endauth
        {{-- @include('layouts.navigation') --}}

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        {{-- Toast Container --}}
        <div id="ef-toast-container" aria-live="polite"></div>
    </div>

    {{-- ✅ Tambahkan ini di bawah --}}
    {{-- @stack('scripts') --}}

    <script>
        window.showToast = function (msg, type = 'success') {
            const container = document.getElementById('ef-toast-container');
            const t = document.createElement('div');
            t.className = `ef-toast ef-toast--${type}`;
            const icon = type === 'success'
                ? '<path d="M20 6L9 17l-5-5"/>'
                : '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>';
            t.innerHTML = `
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">${icon}</svg>
                <span>${msg}</span>`;
            container.prepend(t);
            requestAnimationFrame(() => t.classList.add('ef-toast--show'));
            setTimeout(() => {
                t.classList.remove('ef-toast--show');
                setTimeout(() => t.remove(), 380);
            }, 2800);
        };
    </script>

    @auth
        <script>
            (function () {
                const role = @json(auth()->user()?->getRoleNames()->first() ?? '');
                if (!role || role === 'admin') return;

                const authId = @json(auth()->id());
                const onChatPage = window.location.pathname.includes('/chat');

                const badges = ['chat-badge-desktop', 'chat-badge-mobile']
                    .map(id => document.getElementById(id))
                    .filter(Boolean);

                function updateBadge(count) {
                    badges.forEach(el => {
                        el.textContent = count > 99 ? '99+' : count;
                        el.style.display = count > 0 ? 'inline-flex' : 'none';
                    });
                }

                // Fetch initial unread count
                const endpoint = role === 'courier' ? '/courier/chat/unread' : '/customer/chat/unread';
                if (!onChatPage) {
                    fetch(endpoint, {
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                    })
                        .then(r => r.json())
                        .then(d => updateBadge(d.count ?? 0))
                        .catch(() => { });
                }

                // ← Tunggu Echo siap, cek setiap 100ms sampai max 5 detik
                function waitForEchoAndListen() {
                    let attempts = 0;
                    const interval = setInterval(() => {
                        attempts++;
                        if (window.Echo) {
                            clearInterval(interval);
                            subscribeEcho();
                        }
                        if (attempts > 50) clearInterval(interval); // timeout 5 detik
                    }, 100);
                }

                function subscribeEcho() {
                    window.Echo.private(`user.${authId}`)
                        .listen('.chat.sent', (e) => {
                            if (e.chat.receiver_id !== authId) return;

                            const currentPath = window.location.pathname;
                            const senderId = e.chat.sender_id;
                            // Kalau sedang buka room chat dengan sender ini, skip badge
                            if (onChatPage && currentPath.includes(senderId)) return;

                            const current = parseInt(badges[0]?.textContent) || 0;
                            updateBadge(current + 1);
                        });
                }

                waitForEchoAndListen();
            })();
        </script>
    @endauth

    <script defer>
        document.addEventListener('alpine:init', () => {
            Alpine.data('profileEditor', () => ({
                editMode: new URLSearchParams(window.location.search).has('edit'),

                // Otomatis buka modal kalau ada ?edit di URL
                init() {
                    if (this.editMode) {
                        history.replaceState({}, '', window.location
                            .pathname); // hapus ?edit dari URL biar bersih
                    }
                },

                openEdit() {
                    this.editMode = true;
                    history.pushState({}, '', '?edit'); // tambah ?edit ke URL
                },

                closeEdit() {
                    this.editMode = false;
                    history.replaceState({}, '', window.location.pathname); // bersihkan URL
                },

                form: {
                    name: "{{ addslashes(auth()->user()->name ?? '') }}",
                    phone: "{{ auth()->user()->no_hp ?? '' }}",
                    alamat: "{{ addslashes(auth()->user()->alamat ?? '') }}"
                },

                submit() {
                    fetch("{{ route('courier.profile.update') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify(this.form)
                    })
                        .then(r => r.json())
                        .then(res => {
                            if (res.success) {
                                this.closeEdit();
                                location.reload();
                            } else {
                                alert('Gagal menyimpan');
                            }
                        })
                        .catch(() => alert('Koneksi error'));
                }
            }));
        });
    </script>
</body>

</html>