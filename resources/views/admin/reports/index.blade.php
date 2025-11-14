@extends('layout')

@section('title', 'Laporan')
@section('header', 'Laporan Transaksi')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">MENU LAPORAN</h1>

<div class="bg-white shadow-md rounded-lg p-6">
    <p class="mb-4 text-gray-700">Pilih jenis laporan:</p>

    <div class="space-x-3">
        <a href="{{ route('admin.reports.orders') }}">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Laporan Pesanan
            </button>
        </a>

        <a href="{{ route('admin.reports.couriers') }}">
            <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Laporan Kurir
            </button>
        </a>

        <a href="{{ route('admin.reports.inventory') }}">
            <button class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
                Laporan Inventory
            </button>
        </a>
    </div>
</div>
@endsection
