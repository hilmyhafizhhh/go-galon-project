{{-- @extends('layout')

@section('title', 'Edit Kurir')
@section('header', 'Edit Kurir')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Kurir</h1>

<div class="bg-white shadow-md rounded-lg p-6">
    <form action="{{ route('admin.couriers.update', $courier->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 mb-1">User</label>
            <select name="user_id" required class="w-full border-gray-300 rounded-lg">
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $courier->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-1">Informasi Kendaraan</label>
            <input type="text" name="vehicle_info" value="{{ $courier->vehicle_info }}" class="w-full border-gray-300 rounded-lg">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full border-gray-300 rounded-lg">
                <option value="available" {{ $courier->status == 'available' ? 'selected' : '' }}>Available</option>
                <option value="on_delivery" {{ $courier->status == 'on_delivery' ? 'selected' : '' }}>On Delivery</option>
                <option value="inactive" {{ $courier->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.couriers.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 mr-2">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection --}}

@extends('layout')

@section('title', 'Edit Kurir')
@section('header', 'Edit Kurir')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Kurir</h1>

<div class="bg-white shadow-md rounded-lg p-6">
    <form action="{{ route('admin.couriers.update', $courier->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Akun User --}}
        <h2 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Data Akun Kurir</h2>

        <div class="mb-4">
            <label class="block text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="{{ $courier->user->name }}" required class="w-full border-gray-300 rounded-lg">
        </div>

        {{-- <div class="mb-4">
            <label class="block text-gray-700 mb-1">Username</label>
            <input type="text" name="username" value="{{ $courier->user->username }}" required class="w-full border-gray-300 rounded-lg">
        </div> --}}

        <div class="mb-4">
            <label class="block text-gray-700 mb-1">Username</label>
            <input type="text" name="username" value="{{ old('username', $courier->user->username) }}" required 
            class="w-full rounded-lg {{ $errors->has('username') ? 'border-red-500' : 'border-gray-300' }}">
            {{-- Tambahkan script di bawah ini --}}
            @error('username')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- <div class="mb-6">
            <label class="block text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ $courier->user->email }}" required class="w-full border-gray-300 rounded-lg">
        </div> --}}

        <div class="mb-6">
            <label class="block text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $courier->user->email) }}" required 
            class="w-full rounded-lg {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }}">
            {{-- Tambahkan script di bawah ini --}}
            @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-1">No. Telepon</label>
            <input type="text" 
            name="phone"
            value="{{ old('phone', $courier->user->phone) }}"
            required
            class="w-full rounded-lg border-gray-300">
        </div>

        {{-- Data Operasional --}}
        <h2 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Data Operasional</h2>

        <div class="mb-4">
            <label class="block text-gray-700 mb-1">Informasi Kendaraan</label>
            <input type="text" name="vehicle_info" value="{{ $courier->vehicle_info }}" class="w-full border-gray-300 rounded-lg">
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full border-gray-300 rounded-lg">
                <option value="available" {{ $courier->status == 'available' ? 'selected' : '' }}>Available</option>
                <option value="on_delivery" {{ $courier->status == 'on_delivery' ? 'selected' : '' }}>On Delivery</option>
                <option value="inactive" {{ $courier->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.couriers.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 mr-2">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Simpan Perubahan</button>
        </div>
    </form>
</div>

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true
    });
});
</script>
@endif
@endsection