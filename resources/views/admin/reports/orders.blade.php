@extends('layout')

@section('title', 'Laporan Pesanan')
@section('header', 'Laporan Pesanan')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">LAPORAN PESANAN</h1>

<div class="bg-white shadow-md rounded-lg p-6">
    <table class="min-w-full border-collapse">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2">ID Pesanan</th>
                <th class="px-4 py-2">Nama Pelanggan</th>
                <th class="px-4 py-2">Produk</th>
                <th class="px-4 py-2">Total Harga</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td class="border px-4 py-2">{{ $order->id }}</td>
                <td class="border px-4 py-2">{{ $order->customer_name }}</td>
                <td class="border px-4 py-2">{{ $order->product->name }}</td>
                <td class="border px-4 py-2">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td class="border px-4 py-2">{{ ucfirst($order->status) }}</td>
                <td class="border px-4 py-2">{{ $order->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
