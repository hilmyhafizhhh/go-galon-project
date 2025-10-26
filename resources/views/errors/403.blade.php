<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 | Unauthorized Access</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="text-center">
        <h1 class="text-8xl font-extrabold text-red-600">403</h1>
        <h2 class="mt-4 text-2xl font-semibold text-gray-800">Akses Ditolak</h2>
        <p class="mt-2 text-gray-600">
            Maaf, kamu tidak memiliki izin untuk mengakses halaman ini.<br>
            Silakan hubungi administrator jika kamu merasa ini adalah kesalahan.
        </p>

        <div class="mt-6">
            <a href="{{ url()->previous() }}"
                class="inline-block px-5 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition">
                ← Kembali
            </a>
            <a href="{{ route('admin.dashboard') }}"
                class="inline-block px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition ml-2">
                Dashboard
            </a>
        </div>

        <p class="mt-10 text-sm text-gray-400">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </p>
    </div>
</body>

</html>