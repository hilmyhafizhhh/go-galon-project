@extends('layout')

@section('title', 'Pengaturan')
@section('header', 'Pengaturan Akun')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">PENGATURAN</h1>
<div class="bg-white shadow-md rounded-lg p-6 max-w-lg">
    <form class="space-y-4">
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Nama Admin</label>
            <input type="text" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" value="Admin Utama">
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Email</label>
            <input type="email" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" value="admin@contoh.com">
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Password Baru</label>
            <input type="password" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">
        </div>
        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
    </form>
</div>
@endsection
