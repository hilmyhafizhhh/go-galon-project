@extends('layout')

@section('title', 'Pesanan')
@section('header', 'Daftar Pesanan')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">PESANAN</h1>

{{-- 🔍 Filter Section --}}
<div class="bg-white shadow-md rounded-lg p-6 mb-6">
    <form method="GET" action="{{ route('admin.orders') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-gray-700 text-sm mb-1">Status</label>
            <select name="status" class="w-full border-gray-300 rounded-lg">
                <option value="">Semua</option>
                <option value="waiting" {{ request('status') == 'waiting' ? 'selected' : '' }}>Menunggu</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
                <option value="delivering" {{ request('status') == 'delivering' ? 'selected' : '' }}>Dikirim</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
        </div>

        <div>
            <label class="block text-gray-700 text-sm mb-1">Tanggal Awal</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full border-gray-300 rounded-lg">
        </div>

        <div>
            <label class="block text-gray-700 text-sm mb-1">Tanggal Akhir</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full border-gray-300 rounded-lg">
        </div>

        <div>
            <label class="block text-gray-700 text-sm mb-1">Nama Pelanggan</label>
            <input type="text" name="keyword" placeholder="Cari nama..." value="{{ request('keyword') }}" class="w-full border-gray-300 rounded-lg">
        </div>

        <div class="md:col-span-4 flex justify-end mt-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Filter</button>
            <a href="{{ route('admin.orders') }}" class="ml-2 bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">Reset</a>
        </div>
    </form>
</div>

{{-- 📋 Tabel Pesanan --}}
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
            @forelse ($orders as $order)
                <tr>
                    <td class="border px-4 py-2">{{ $order->order_code }}</td>
                    <td class="border px-4 py-2">{{ $order->user->name ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $order->created_at->format('Y-m-d') }}</td>
                    <td class="border px-4 py-2 font-semibold
                        @if ($order->status == 'completed') text-green-600
                        @elseif ($order->status == 'delivering') text-blue-600
                        @elseif ($order->status == 'cancelled') text-red-600
                        @else text-yellow-600 @endif">
                        {{ ucfirst($order->status) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500">Tidak ada data pesanan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- 🔢 Pagination --}}
    <div class="mt-4">
        {{ $orders->withQueryString()->links() }}
    </div>
</div>
@endsection
