<x-app-layout>
    <div class=" w-full px-2 sm:px-4 md:px-6 lg:px-40 py-6">

        @php
            $activeTab = request('tab', 'riwayat');

            $tabs = [
                'riwayat' => 'Riwayat',
                'dalam' => 'Dalam Pengantaran',
                'draf' => 'Draf',
                'batal' => 'Batal',
            ];

            $orders = [
                (object) [
                    'id' => 124,
                    'toko' => 'Gogalon Maospat',
                    'status' => 'dalam',
                    'statusText' => 'Dalam pengantaran',
                    'statusColor' => 'orange',
                    'date' => '30 Okt, 18:41',
                    'barang' => '2 Galon Aqua',
                    'price' => 'Rp28.000',
                ],
                (object) [
                    'id' => 123,
                    'toko' => 'Depot Air Salwa',
                    'status' => 'riwayat',
                    'statusText' => 'Pesanan selesai',
                    'statusColor' => 'green',
                    'date' => '29 Okt, 22:58',
                    'barang' => '1 Galon Aqua',
                    'price' => 'Rp14.000',
                ],
                (object) [
                    'id' => 122,
                    'toko' => 'Depot Air Mas Jaya',
                    'status' => 'batal',
                    'statusText' => 'Pesanan dibatalkan',
                    'statusColor' => 'gray',
                    'date' => '28 Okt, 21:15',
                    'barang' => '2 Galon Club',
                    'price' => 'Rp28.000',
                ],
                (object) [
                    'id' => 121,
                    'toko' => 'Gogalon Express',
                    'status' => 'draf',
                    'statusText' => 'Draf',
                    'statusColor' => 'gray',
                    'date' => '—',
                    'barang' => '1 Galon Aqua',
                    'price' => 'Rp14.000',
                ],
            ];
        @endphp

        <div class="min-h-screen bg-gray-50">

            {{-- HEADER --}}
            <div class="bg-white px-4 pt-4 pb-3 shadow-sm sticky top-0 z-40">
                <h1 class="text-xl font-bold">Aktivitas</h1>

                {{-- FILTER TAB --}}
                <div class="flex gap-2 mt-3 overflow-x-auto">
                    @foreach ($tabs as $key => $label)
                                    <a href="?tab={{ $key }}" class="px-4 py-2 rounded-full text-sm font-semibold whitespace-nowrap
                                                               {{ $activeTab === $key
                        ? 'bg-green-600 text-white'
                        : 'bg-gray-100 text-gray-700' }}">
                                        {{ $label }}
                                    </a>
                    @endforeach
                </div>
            </div>

            {{-- LIST PESANAN --}}
            <div class="px-4 mt-4 space-y-3 pb-24">

                @forelse ($orders as $order)
                    @if ($order->status === $activeTab)

                        <div class="bg-white rounded-xl shadow-sm p-3 flex gap-3">

                            {{-- ICON GALON --}}
                            <div class="w-16 h-16 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                                <img src="{{ asset('assets/icons/galon.png') }}" alt="galon" class="w-10 h-10">
                            </div>

                            {{-- CONTENT --}}
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <p class="font-semibold text-sm">{{ $order->toko }}</p>

                                    <span class="text-xs px-2 py-1 rounded-full
                                                    @if($order->statusColor === 'green') bg-green- 100 text-green-700 @endif
                                                    @if($order->statusColor === 'orange') bg-orange-100 text-orange-700 @endif
                                                    @if($order->statusColor === 'gray') bg-gray-200 text-gray-600 @endif
                                                ">
                                        {{ $order->statusText }}
                                    </span>
                                </div>

                                <p class="text-xs text-gray-500 mt-1">{{ $order->date }}</p>
                                <p class="text-sm mt-1">{{ $order->barang }}</p>

                                <div class="flex justify-between items-center mt-2">
                                    <p class="font-semibold text-sm">{{ $order->price }}</p>

                                    @if ($order->status === 'riwayat')
                                        <button class="text-green-600 text-sm font-semibold">
                                            Pesan lagi
                                        </button>
                                    @elseif ($order->status === 'dalam')
                                        <button class="text-orange-600 text-sm font-semibold">
                                            Lacak
                                        </button>
                                    @elseif ($order->status === 'draf')
                                        <button class="text-blue-600 text-sm font-semibold">
                                            Lanjutkan
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                    @endif
                @empty
                    <p class="text-center text-gray-500 mt-10">
                        Tidak ada pesanan
                    </p>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>