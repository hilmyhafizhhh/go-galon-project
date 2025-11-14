@extends('layout')

@section('title', 'Laporan Kurir')
@section('header', 'Laporan Kurir')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">LAPORAN KURIR</h1>

<div class="bg-white shadow-md rounded-lg p-6">
    <table class="min-w-full border-collapse">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2">ID Kurir</th>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">No. Telepon</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Total Pesanan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($couriers as $courier)
            <tr>
                <td class="border px-4 py-2">{{ $courier->id }}</td>
                <td class="border px-4 py-2">{{ $courier->user->name }}</td>
                <td class="border px-4 py-2">{{ $courier->user->phone }}</td>
                <td class="border px-4 py-2">{{ ucfirst($courier->status) }}</td>
                <td class="border px-4 py-2">{{ $courier->assignedOrders->count() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
