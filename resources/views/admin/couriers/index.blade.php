@extends('layout')

@section('title', 'Kurir')
@section('header', 'Data Kurir')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">KURIR</h1>

{{-- ✅ Notifikasi --}}
@if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

{{-- 🔍 Filter dan Tombol Tambah --}}
<div class="bg-white shadow-md rounded-lg p-6 mb-6">
    <form method="GET" action="{{ route('admin.couriers.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-gray-700 text-sm mb-1">Status</label>
            <select name="status" class="w-full border-gray-300 rounded-lg">
                <option value="">Semua</option>
                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                <option value="on_delivery" {{ request('status') == 'on_delivery' ? 'selected' : '' }}>On Delivery</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="md:col-span-2">
            <label class="block text-gray-700 text-sm mb-1">Cari Nama / Email</label>
            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Masukkan kata kunci..." class="w-full border-gray-300 rounded-lg">
        </div>

        <div class="flex items-end justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Filter</button>
            <a href="{{ route('admin.couriers.index') }}" class="ml-2 bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">Reset</a>
        </div>
    </form>
</div>

{{-- 🧾 Tabel Data --}}
<div class="bg-white shadow-md rounded-lg p-6">
    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.couriers.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">+ Tambah Kurir</a>
    </div>

    <table class="min-w-full border-collapse">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2 text-left">ID Kurir</th>
                <th class="px-4 py-2 text-left">Nama</th>
                <th class="px-4 py-2 text-left">Kendaraan</th>
                <th class="px-4 py-2 text-left">Status</th>
                <th class="px-4 py-2 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($couriers as $courier)
                <tr>
                    <td class="border px-4 py-2">{{ $courier->id }}</td>
                    <td class="border px-4 py-2">{{ $courier->user->name ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $courier->vehicle_info ?? '-' }}</td>
                    <td class="border px-4 py-2 font-semibold
                        @if($courier->status == 'available') text-green-600
                        @elseif($courier->status == 'on_delivery') text-blue-600
                        @else text-gray-600 @endif">
                        {{ ucfirst($courier->status) }}
                    </td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('admin.couriers.edit', $courier->id) }}" class="text-blue-600 hover:underline">Edit</a> |
                        <form action="{{ route('admin.couriers.destroy', $courier->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus data kurir ini?')" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center py-4 text-gray-500">Tidak ada data kurir</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $couriers->withQueryString()->links() }}
    </div>
</div>
@endsection
