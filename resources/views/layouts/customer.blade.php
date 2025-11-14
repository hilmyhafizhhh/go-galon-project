<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Panel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans bg-gray-100">

    {{-- NAVBAR customer --}}
    @include('layouts.navigation-customer')

    {{-- CONTENT --}}
    <main class="max-w-7xl mx-auto p-6">
        {{ $slot }}
    </main>

</body>

</html>