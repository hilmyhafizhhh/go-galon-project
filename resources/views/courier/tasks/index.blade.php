@extends('layout')

@section('title', 'Pesanan Saya')
@section('header', 'Daftar Pesanan')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">PESANAN SAYA</h1>

{{-- Notifikasi --}}
@if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

{{-- Statistik --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
        <p class="text-sm text-yellow-600 font-medium">Menunggu Pickup</p>
        <p class="text-3xl font-bold text-yellow-700">{{ $totalPending }}</p>
    </div>
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
        <p class="text-sm text-blue-600 font-medium">Sedang Diantar</p>
        <p class="text-3xl font-bold text-blue-700">{{ $totalPickedUp }}</p>
    </div>
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
        <p class="text-sm text-green-600 font-medium">Selesai</p>
        <p class="text-3xl font-bold text-green-700">{{ $totalCompleted }}</p>
    </div>
</div>

{{-- Filter Status --}}
<div class="bg-white shadow-md rounded-lg p-4 mb-6">
    <form method="GET" action="{{ route('courier.tasks') }}" class="flex flex-wrap gap-2 items-end">
        <div>
            <label class="block text-gray-700 text-sm mb-1">Filter Status</label>
            <select name="status" class="border-gray-300 rounded-lg">
                <option value="">Semua</option>
                <option value="pending"   {{ request('status') == 'pending'    ? 'selected' : '' }}>Pending</option>
                <option value="picked_up" {{ request('status') == 'picked_up'  ? 'selected' : '' }}>Picked Up</option>
                <option value="completed" {{ request('status') == 'completed'  ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Filter</button>
        <a href="{{ route('courier.tasks') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400">Reset</a>
    </form>
</div>

{{-- Daftar Pesanan --}}
<div class="space-y-4">
    @forelse ($tasks as $task)
        @php $order = $task->order; @endphp
        <div class="bg-white shadow-md rounded-lg p-5 border-l-4
            @if($task->status == 'pending')   border-yellow-400
            @elseif($task->status == 'picked_up') border-blue-400
            @else border-green-400 @endif">

            <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                {{-- Info Pesanan --}}
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="font-bold text-gray-800 text-lg">
                            {{ $order->order_code ?? 'ORD-' . substr($order->id, 0, 8) }}
                        </span>
                        <span class="px-2 py-0.5 text-xs rounded-full font-semibold
                            @if($task->status == 'pending')    bg-yellow-100 text-yellow-700
                            @elseif($task->status == 'picked_up') bg-blue-100 text-blue-700
                            @else bg-green-100 text-green-700 @endif">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-1 text-sm text-gray-600">
                        <div>
                            <span class="font-medium text-gray-700">Pelanggan:</span>
                            {{ $order->user->name ?? '-' }}
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Total:</span>
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Pembayaran:</span>
                            <span class="{{ $order->payment_status == 'paid' ? 'text-green-600' : 'text-red-500' }} font-semibold">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Tanggal Pickup:</span>
                            {{ $task->pickup_date ? \Carbon\Carbon::parse($task->pickup_date)->format('d M Y') : '-' }}
                        </div>
                        @if($order->address)
                        <div class="md:col-span-2">
                            <span class="font-medium text-gray-700">Alamat:</span>
                            {{ $order->address->full_address ?? $order->address->address ?? '-' }}
                        </div>
                        @endif
                    </div>

                    {{-- Item Pesanan --}}
                    @if($order->items && $order->items->count())
                    <div class="mt-2">
                        <p class="text-xs font-medium text-gray-500 mb-1">Item ({{ $order->items->count() }}):</p>
                        <div class="flex flex-wrap gap-1">
                            @foreach($order->items->take(3) as $item)
                                <span class="bg-gray-100 text-gray-700 text-xs px-2 py-0.5 rounded">
                                    {{ $item->product->name ?? 'Item' }} x{{ $item->quantity }}
                                </span>
                            @endforeach
                            @if($order->items->count() > 3)
                                <span class="text-xs text-gray-400">+{{ $order->items->count() - 3 }} lainnya</span>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex flex-col gap-2 min-w-[130px]">
                    @if($task->status == 'pending')
                        <form action="{{ route('courier.task.pickup', $task->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                onclick="return confirm('Konfirmasi pickup pesanan ini?')"
                                class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium transition">
                                📦 Pickup
                            </button>
                        </form>
                    @elseif($task->status == 'picked_up')
                        <form action="{{ route('courier.task.deliver', $task->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                onclick="return confirm('Konfirmasi pesanan sudah diterima pelanggan?')"
                                class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm font-medium transition">
                                ✅ Selesai
                            </button>
                        </form>
                    @else
                        <span class="text-center text-sm text-green-600 font-semibold py-2">
                            ✓ Terkirim
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white shadow-md rounded-lg p-10 text-center text-gray-500">
            <p class="text-4xl mb-2">📭</p>
            <p>Tidak ada pesanan saat ini</p>
        </div>
    @endforelse
</div>

{{-- Pagination --}}
<div class="mt-6">
    {{ $tasks->withQueryString()->links() }}
</div>

@endsection