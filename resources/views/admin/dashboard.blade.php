{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Ini dashboard admin") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

<!-- resources/views/admin/dashboard.blade.php -->
@extends('layout')

@section('content')
    <h1 class="text-2xl font-bold text-gray-800 mb-6">DASHBOARD</h1>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-xl shadow text-center">
            <p class="text-gray-500">Total Pesanan</p>
            <h2 class="text-2xl font-bold text-blue-600">125</h2>
        </div>
        <div class="bg-white p-4 rounded-xl shadow text-center">
            <p class="text-gray-500">Pendapatan Hari Ini</p>
            <h2 class="text-2xl font-bold text-green-600">Rp.300rb</h2>
        </div>
        <div class="bg-white p-4 rounded-xl shadow text-center">
            <p class="text-gray-500">Pesanan Aktif</p>
            <h2 class="text-2xl font-bold text-orange-500">12 🛵</h2>
        </div>
        <div class="bg-white p-4 rounded-xl shadow text-center">
            <p class="text-gray-500">Kurir Online</p>
            <h2 class="text-2xl font-bold text-purple-600">1/2</h2>
        </div>
    </div>

    <!-- Daftar Pesanan -->
    <div class="bg-white p-4 rounded-xl shadow mb-6">
        <h2 class="font-semibold text-lg mb-4">Daftar Pesanan</h2>
        <table class="min-w-full border text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="border p-2 text-left">ID</th>
                    <th class="border p-2 text-left">Customer</th>
                    <th class="border p-2 text-left">Item</th>
                    <th class="border p-2 text-left">Status</th>
                    <th class="border p-2 text-left">Kurir</th>
                    <th class="border p-2 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border p-2">124</td>
                    <td class="border p-2">Marno</td>
                    <td class="border p-2">2 Aqua 19L</td>
                    <td class="border p-2">
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Dalam Pengantaran</span>
                    </td>
                    <td class="border p-2">Efata</td>
                    <td class="border p-2 text-center space-x-2">
                        <button class="text-blue-600">🔍</button>
                        <button class="text-green-600">✏️</button>
                        <button class="text-red-600">❌</button>
                    </td>
                </tr>
                <tr>
                    <td class="border p-2">123</td>
                    <td class="border p-2">Hilmy</td>
                    <td class="border p-2">1 Le Minerale 19L</td>
                    <td class="border p-2">
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Selesai</span>
                    </td>
                    <td class="border p-2">Efata</td>
                    <td class="border p-2 text-center space-x-2">
                        <button class="text-blue-600">🔍</button>
                        <button class="text-green-600">✏️</button>
                        <button class="text-red-600">❌</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Kurir & Inventory -->
    <div class="grid grid-cols-2 gap-6">
        <div class="bg-white p-4 rounded-xl shadow">
            <h2 class="font-semibold mb-2">Kurir Aktif</h2>
            <p><strong>Efata</strong> (Online)</p>
            <p>Pesanan: 2</p>
            <button class="mt-3 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Assign</button>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
            <h2 class="font-semibold mb-2">Inventory Galon</h2>
            <div class="space-y-2 text-sm">
                <p>Aqua 19L → <span class="text-green-600">Stock: 45 | Rp.8.000</span> ✅</p>
                <p>Le Minerale 19L → <span class="text-yellow-600">Stock: 15 | Rp.6.000</span> ⚠️</p>
            </div>
            <button class="mt-3 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tambah Stok</button>
        </div>
    </div>
@endsection
