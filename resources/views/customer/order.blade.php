<x-app-layout>
    <div class=" w-full px-2 sm:px-4 md:px-6 lg:px-40 py-6">

        <div class="mb-4 rounded-sm p-4 flex flex-wrap justify-center font-semibold items-center">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gogalon-primary">Pesanan Saya</h1>
        </div>

        @php
            $orders = [
                (object)[
                    'id' => 124,
                    'status' => 'Dalam Pengantaran 🛵',
                    'statusColor' => 'orange-500',
                    'statusLabel' => 'Aktif',
                    'date' => '16 Oktober 2025',
                    'time' => '14:30',
                    'price' => 'Rp. 6.000',
                    'kurir' => 'Budi',
                    'nohp' => '0812-3902-1134',
                    'eta' => '10 Menit',
                    'barang' => '2 Galon Aqua',
                ],
                (object)[
                    'id' => 123,
                    'status' => 'Selesai ✅',
                    'statusColor' => 'gogalon-tiga',
                    'statusLabel' => 'Selesai',
                    'date' => '12 Oktober 2025',
                    'time' => '09:30',
                    'price' => 'Rp. 6.000',
                    'kurir' => 'Andi',
                    'nohp' => '0812-5555-8888',
                    'eta' => '—',
                    'barang' => '1 Galon Aqua',
                ],
                (object)[
                    'id' => 122,
                    'status' => 'Dibatalkan ❌',
                    'statusColor' => 'gray-400',
                    'statusLabel' => 'Dibatalkan',
                    'date' => '10 Oktober 2025',
                    'time' => '08:15',
                    'price' => 'Rp. 12.000',
                    'kurir' => 'Rudi',
                    'nohp' => '0812-7777-3333',
                    'eta' => '—',
                    'barang' => '2 Galon Club',
                ],
            ];
        @endphp

        @foreach ($orders as $order)
            <div class="bg-white w-full rounded-sm shadow-sm border-l-2 border-{{ $order->statusColor }} mb-2">
                <div class="w-full flex justify-between items-center p-4">
                    <p class="bg-{{ $order->statusColor }} text-white rounded-lg px-2">#{{ $order->id }}</p>
                    <p class="text-{{ $order->statusColor }} font-semibold ml-2">{{ $order->status }}</p>
                    <p class="text-white rounded-full bg-{{ $order->statusColor }}/70 px-2">{{ $order->statusLabel }}</p>
                </div>

                <div class="w-full flex justify-start items-center gap-6 px-4 text-sm text-gray-600">
                    <p>{{ $order->date }}</p>
                    <p>{{ $order->time }}</p>
                </div>

                <div class="w-full flex justify-start items-center gap-6 px-4 text-sm text-gogalon-primary font-semibold border-t border-gray-300 pt-2">
                    <p>{{ $order->price }}</p>
                </div>

                {{-- Tombol buka popup --}}
                <div class="w-full flex justify-between items-center p-4 text-sm text-gogalon-primary font-semibold">
                    <p>Detail Pesanan</p>
                    <button class="openTracking" data-id="{{ $order->id }}">
                        <img src="{{ asset('assets/icons/Arrow.svg') }}" alt="arrow" class="w-4 h-4">
                    </button>
                </div>
            </div>

            {{-- POPUP --}}
            <div id="trackingCard-{{ $order->id }}" class="fixed inset-0 bg-black/40 hidden justify-center items-center z-50">
                <div class="bg-white w-11/12 max-w-sm rounded-xl shadow-lg overflow-hidden">
                    <div class="flex justify-between items-center bg-white text-gogalon-primary">
                        <h2 class="font-semibold text-lg px-4 py-4">Tracking Pesanan #{{ $order->id }}</h2>
                        <button class="closeTracking">
                            <img src="{{ asset('assets/icons/Cancel.svg') }}" alt="cancel" class="px-4 py-4 w-16 h-16">
                        </button>
                    </div>

                    <div>
                        <img src="{{ asset('assets/icons/map.png') }}" alt="map" class="w-full h-48 object-cover bg-gray-500">
                    </div>

                    <div class="p-4 text-sm text-gray-400">
                        <div class="flex justify-between items-center">
                            <p><span class="font-semibold text-gogalon-primary">Kurir:</span> {{ $order->kurir }}<br>{{ $order->nohp }}</p>
                            <span class="bg-gogalon-tiga/20 text-green-700 rounded-full text-xs px-2 py-1">Online</span>
                        </div>

                        <div class="flex justify-between">
                            <p>Estimasi Tiba:</p>
                            <p class="text-orange-500 font-semibold">{{ $order->eta }}</p>
                        </div>

                        <div class="flex justify-between">
                            <p>Status</p>
                            <p class="text-orange-500 font-semibold">{{ $order->status }}</p>
                        </div>

                        <div class="flex justify-between">
                            <p>Pesanan</p>
                            <p class="text-gogalon-primary font-semibold">{{ $order->barang }}</p>
                        </div>

                        <div class="w-full bg-gray-200 rounded-full h-2 mt-4">
                            <div class="bg-orange-500 h-2 rounded-full w-1/2"></div>
                        </div>
                    </div>

                    <div class="w-full shadow-sm rounded-sm p-4 flex flex-wrap justify-center items-center gap-4">
                        <button class="w-full bg-sky-400 flex justify-center items-center gap-2 px-4 py-2 rounded-md text-white font-semibold">
                            <img src="{{ asset('assets/icons/Phone.svg') }}" alt="Phone">
                            <p>Hubungi Kurir</p>
                        </button>
                        <button class="w-full bg-white flex justify-center items-center gap-2 px-4 py-2 rounded-md text-gogalon-secondary font-semibold shadow-sm border border-sky-500/50 mb-8">
                            <img src="{{ asset('assets/icons/Maps.svg') }}" alt="Maps">
                            <p>Lihat Rute</p>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- SCRIPT POPUP --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const openButtons = document.querySelectorAll('.openTracking');
                const closeButtons = document.querySelectorAll('.closeTracking');

                openButtons.forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id = btn.dataset.id;
                        const card = document.getElementById(`trackingCard-${id}`);
                        card.classList.remove('hidden');
                        card.classList.add('flex');
                    });
                });

                closeButtons.forEach(btn => {
                    btn.addEventListener('click', () => {
                        btn.closest('.fixed').classList.add('hidden');
                        btn.closest('.fixed').classList.remove('flex');
                    });
                });
            });
        </script>
    </div>
</x-app-layout>
