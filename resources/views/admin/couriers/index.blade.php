@extends('layout')

@section('title', 'Kurir')
@section('header', 'Data Kurir')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    <table class="min-w-full border-collapse">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2 text-left">ID Kurir</th>
                <th class="px-4 py-2 text-left">Nama</th>
                <th class="px-4 py-2 text-left">No. Telepon</th>
                <th class="px-4 py-2 text-left">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border px-4 py-2">KUR-001</td>
                <td class="border px-4 py-2">Dewi Lestari</td>
                <td class="border px-4 py-2">08123456789</td>
                <td class="border px-4 py-2 text-green-600 font-semibold">Aktif</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
