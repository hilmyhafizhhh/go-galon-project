@extends('layout')

@section('title', 'Tambah Produk')
@section('header', 'Tambah Produk')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">TAMBAH PRODUK</h1>

<div class="bg-white shadow-md rounded-lg p-6">
    <form action="{{ route('admin.inventory.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold mb-2">Nama Barang</label>
            <input type="text" name="name" class="w-full border px-4 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-2">Kategori</label>
            <input type="text" name="category" class="w-full border px-4 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-2">Volume (ML)</label>
            <input type="number" name="volume_ml" class="w-full border px-4 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-2">Harga</label>
            <input type="number" step="0.01" name="price" class="w-full border px-4 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-2">Stok</label>
            <input type="number" name="stock" class="w-full border px-4 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-2">Status</label>
            <select name="status" class="w-full border px-4 py-2 rounded">
                <option value="available">Available</option>
                <option value="unavailable">Unavailable</option>
            </select>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        </div>
    </form>
</div>
@endsection
