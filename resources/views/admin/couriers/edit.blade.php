@extends('layout')

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
@endsection
