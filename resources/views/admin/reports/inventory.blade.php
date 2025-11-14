@extends('layout')

@section('title', 'Laporan Inventory')
@section('header', 'Laporan Inventory')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">LAPORAN INVENTORY</h1>

<div class="bg-white shadow-md rounded-lg p-6">
    <table class="min-w-full border-collapse">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2">Nama Produk</th>
                <th class="px-4 py-2">Kategori</th>
                <th class="px-4 py-2">Volume</th>
                <th class="px-4 py-2">Harga</th>
                <th class="px-4 py-2">Stok</th>
                <th class="px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td class="border px-4 py-2">{{ $product->name }}</td>
                <td class="border px-4 py-2">{{ $product->category }}</td>
                <td class="border px-4 py-2">{{ $product->volume_ml }} ml</td>
                <td class="border px-4 py-2">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="border px-4 py-2">{{ $product->stock }}</td>
                <td class="border px-4 py-2">{{ ucfirst($product->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
