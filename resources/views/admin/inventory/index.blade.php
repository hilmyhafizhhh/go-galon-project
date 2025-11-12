@extends('layout')

@section('title', 'Inventory')
@section('header', 'Data Inventory')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">INVENTORY</h1>
<div class="bg-white shadow-md rounded-lg p-6">
    <table class="min-w-full border-collapse">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2 text-left">Kode Barang</th>
                <th class="px-4 py-2 text-left">Nama Barang</th>
                <th class="px-4 py-2 text-left">Stok</th>
                <th class="px-4 py-2 text-left">Harga</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border px-4 py-2">BRG-101</td>
                <td class="border px-4 py-2">Galon Air 19L</td>
                <td class="border px-4 py-2">50</td>
                <td class="border px-4 py-2">Rp 25.000</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
