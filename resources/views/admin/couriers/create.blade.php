{{-- @extends('layout')

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
            <input type="text" name="vehicle_info" class="w-full border-gray-300 rounded-lg"
                placeholder="Contoh: Motor Honda Beat">
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
            <a href="{{ route('admin.couriers.index') }}"
                class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 mr-2">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection --}}

@extends('layout')

@section('title', 'Tambah Kurir')
@section('header', 'Tambah Kurir')

@section('content')
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Kurir</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('admin.couriers.store') }}" method="POST">
            @csrf

            {{-- Akun User --}}
            <h2 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Data Akun Kurir</h2>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" required class="w-full border-gray-300 rounded-lg"
                    placeholder="Masukkan nama kurir">
            </div>

            {{-- <div class="mb-4">
                <label class="block text-gray-700 mb-1">Username</label>
                <input type="text" name="username" required class="w-full border-gray-300 rounded-lg"
                    placeholder="Masukkan username unik (tanpa spasi)">
            </div> --}}

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" required
                    class="w-full rounded-lg {{ $errors->has('username') ? 'border-red-500' : 'border-gray-300' }}"
                    placeholder="Masukkan username unik (tanpa spasi)">
                {{-- Tambahkan script di bawah ini --}}
                @error('username')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- <div class="mb-4">
                <label class="block text-gray-700 mb-1">Email</label>
                <input type="email" name="email" required class="w-full border-gray-300 rounded-lg"
                    placeholder="kurir@email.com">
            </div> --}}

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full rounded-lg {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }}"
                    placeholder="kurir@email.com">
                {{-- Tambahkan script di bawah ini --}}
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">No. Telepon</label>
                <input type="text" name="phone" value="{{ old('phone') }}" required
                    class="w-full rounded-lg border-gray-300" placeholder="Contoh: 08123456789">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required class="w-full border-gray-300 rounded-lg"
                    placeholder="Minimal 8 karakter">
            </div>

            {{-- Data Operasional --}}
            <h2 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Data Operasional</h2>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Informasi Kendaraan</label>
                <input type="text" name="vehicle_info" class="w-full border-gray-300 rounded-lg"
                    placeholder="Contoh: Motor Honda Beat">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border-gray-300 rounded-lg">
                    <option value="available">Available</option>
                    <option value="on_delivery">On Delivery</option>
                    <option value="unavailable">Unavailable</option>
                </select>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.couriers.index') }}"
                    class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 mr-2">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
@endsection