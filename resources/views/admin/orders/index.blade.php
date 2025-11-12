@extends('layout')

@section('title', 'Pesanan')
@section('header', 'Daftar Pesanan')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">PESANAN</h1>
<div class="bg-white shadow-md rounded-lg p-6">
    <table class="min-w-full border-collapse">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2 text-left">ID Pesanan</th>
                <th class="px-4 py-2 text-left">Nama Pelanggan</th>
                <th class="px-4 py-2 text-left">Tanggal</th>
                <th class="px-4 py-2 text-left">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border px-4 py-2">ORD-001</td>
                <td class="border px-4 py-2">Budi Santoso</td>
                <td class="border px-4 py-2">2025-11-10</td>
                <td class="border px-4 py-2 text-green-600 font-semibold">Selesai</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
