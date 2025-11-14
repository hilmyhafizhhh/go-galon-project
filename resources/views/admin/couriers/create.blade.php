@extends('layout')

@section('title', 'Tambah Kurir')
@section('header', 'Tambah Kurir')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Kurir</h1>

<div class="bg-white shadow-md rounded-lg p-6">
    <form action="{{ route('admin.couriers.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 mb-1">Nama</label>
            <select name="user_id" required class="w-full border-gray-300 rounded-lg">
                <option value="">Masukan Nama</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-1">Informasi Kendaraan</label>
            <input type="text" name="vehicle_info" class="w-full border-gray-300 rounded-lg" placeholder="Contoh: Motor Honda Beat">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full border-gray-300 rounded-lg">
                <option value="available">Available</option>
                <option value="on_delivery">On Delivery</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.couriers.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 mr-2">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection
