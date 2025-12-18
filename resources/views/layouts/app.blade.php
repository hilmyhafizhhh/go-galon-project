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
    </div>

    {{-- ✅ Tambahkan ini di bawah --}}
    {{-- @stack('scripts') --}}

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
