@extends('layout')

@section('title', 'Inventory')
@section('header', 'Data Inventory')

@section('content')

<h1 class="text-2xl font-bold text-gray-800 mb-6">INVENTORY</h1>

<div class="mb-4 flex justify-between">
    <form method="GET" action="{{ route('admin.inventory.index') }}" class="flex gap-2">

        <input type="text" name="search" placeholder="Cari nama barang..."
               value="{{ request('search') }}"
               class="px-3 py-2 border rounded">

        <select name="category" class="px-3 py-2 border rounded">
            <option value="">--Kategori--</option>
            <option value="air" {{ request('category') == 'air' ? 'selected' : '' }}>Air</option>
            <option value="aksesoris" {{ request('category') == 'aksesoris' ? 'selected' : '' }}>Aksesoris</option>
        </select>

        <select name="status" class="px-3 py-2 border rounded">
            <option value="">--Status--</option>
            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
            <option value="unavailable" {{ request('status') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
        </select>

        <button class="bg-blue-600 text-white px-3 py-2 rounded">Filter</button>
    </form>

    <a href="{{ route('admin.inventory.create') }}"
       class="bg-green-600 text-white px-4 py-2 rounded">
        + Tambah Barang
    </a>
</div>

<div class="bg-white shadow-md rounded-lg p-6">
    <table class="min-w-full border-collapse">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2 text-left">Nama Barang</th>
                <th class="px-4 py-2 text-left">Kategori</th>
                <th class="px-4 py-2 text-left">Volume (L)</th>
                <th class="px-4 py-2 text-left">Stok</th>
                <th class="px-4 py-2 text-left">Harga</th>
                <th class="px-4 py-2 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $p)
            <tr>
                <td class="border px-4 py-2">{{ $p->name }}</td>
                <td class="border px-4 py-2">{{ $p->category }}</td>
                <td class="border px-4 py-2">{{ $p->volume_ml }}</td>
                <td class="border px-4 py-2">{{ $p->stock }}</td>
                <td class="border px-4 py-2">Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                <td class="border px-4 py-2 flex gap-2">
                    <a href="{{ route('admin.inventory.edit', $p->id) }}"
                       class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</a>

                    <form action="{{ route('admin.inventory.destroy', $p->id) }}" method="POST"
                          onsubmit="return confirm('Hapus barang ini?');">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-600 text-white px-3 py-1 rounded">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="border px-4 py-4 text-center text-gray-500">
                    Tidak ada data
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
