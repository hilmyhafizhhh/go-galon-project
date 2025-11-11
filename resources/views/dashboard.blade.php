<x-app-layout>
    {{-- Main Content --}}
    <main class="bg-gray-50 dark:bg-gray-950 min-h-screen transition-colors duration-300">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 grid grid-cols-1 lg:grid-cols-3 gap-6 transition-all duration-300">

            {{-- Kiri: Banner & Produk --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Banner Promosi --}}
                <div class="rounded-xl overflow-hidden shadow-lg">
                    <img src="{{ asset('assets/icons/Frame 48.png') }}" alt="Banner Promosi"
                        class="w-full h-40 sm:h-52 md:h-64 lg:h-72 object-cover">
                </div>

                {{-- Produk Populer --}}
                <section>
                    <h2
                        class="text-base sm:text-lg font-bold mb-4 flex items-center gap-1 text-gray-800 dark:text-gray-100">
                        💧 Produk Pesanan
                    </h2>

                    <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-5">
                        {{-- Produk 1 --}}
                        <div
                            class="bg-white dark:bg-gray-800 rounded-xl p-3 sm:p-4 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition duration-200">
                            <div class="bg-blue-100 dark:bg-blue-900/30 rounded-lg p-3 mb-2 text-center">
                                <img src="{{ asset('assets/icons/galon.svg') }}" alt="Aqua"
                                    class="w-20 h-20 sm:w-14 sm:h-14 mx-auto">
                            </div>
                            <h3 class="font-semibold text-sm sm:text-base mb-1 text-gray-800 dark:text-gray-100">Aqua
                                19L</h3>
                            <p class="text-blue-800 dark:text-blue-400 font-bold text-lg sm:text-xl mb-2">Rp18.000</p>
                            <button
                                class="w-full bg-blue-800 dark:bg-blue-600 text-white py-2 sm:py-2.5 rounded-lg text-xs sm:text-sm font-semibold hover:bg-blue-700 dark:hover:bg-blue-500 transition flex items-center justify-center gap-1 sm:gap-2">
                                <img src="{{ asset('assets/icons/plus.svg') }}" alt="Tambah" {{-- class="w-4 h-4 sm:w-5 sm:h-5"> --}}
                                    Pesan </button>
                        </div>

                        {{-- Produk 2 --}}
                        <div
                            class="bg-white dark:bg-gray-800 rounded-xl p-3 sm:p-4 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition duration-200">
                            <div class="bg-green-100 dark:bg-green-900/30 rounded-lg p-3 mb-2 text-center">
                                <img src="{{ asset('assets/icons/galon.svg') }}" alt="Le Minerale"
                                    class="w-20 h-20 sm:w-14 sm:h-14 mx-auto">
                            </div>
                            <h3 class="font-semibold text-sm sm:text-base mb-1 text-gray-800 dark:text-gray-100">Le
                                Minerale 19L</h3>
                            <p class="text-blue-800 dark:text-blue-400 font-bold text-lg sm:text-xl mb-2">Rp17.000</p>
                            <button
                                class="w-full bg-blue-800 dark:bg-blue-600 text-white py-2 sm:py-2.5 rounded-lg text-xs sm:text-sm font-semibold hover:bg-blue-700 dark:hover:bg-blue-500 transition flex items-center justify-center gap-1 sm:gap-2">
                                {{-- <img src="{{ asset('assets/icons/plus.svg') }}" alt="Tambah"
                                    class="w-4 h-4 sm:w-5 sm:h-5"> --}}
                                Pesan
                            </button>
                        </div>
                    </div>
                </section>
            </div>

            {{-- Kanan: Info & Status Pesanan --}}
            <aside class="space-y-6">
                {{-- Info Singkat --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl p-4 sm:p-6 shadow-md border border-gray-100 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">📍 Lokasi Pengantaran</p>
                            <p class="font-semibold text-sm sm:text-base text-gray-800 dark:text-gray-100">Jl. Soekarno
                                No.88</p>
                        </div>
                        <img src="{{ asset('assets/icons/Maps.svg') }}" alt="Lokasi" class="w-6 h-6 sm:w-8 sm:h-8">
                    </div>

                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Pesanan Aktif</p>
                            <p class="font-semibold text-blue-800 dark:text-blue-400 text-sm sm:text-base">2 Galon</p>
                        </div>
                        <img src="{{ asset('assets/icons/Shopping Cart.svg') }}" alt="Keranjang"
                            class="w-6 h-6 sm:w-8 sm:h-8">
                    </div>

                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Status</p>
                            <p class="font-semibold text-orange-500 text-sm sm:text-base">Sedang Dalam Pengantaran 🛵
                            </p>
                        </div>
                        <img src="{{ asset('assets/icons/Delivery Scooter.svg') }}" alt="Pengantaran"
                            class="w-6 h-6 sm:w-8 sm:h-8 animate-pulse">
                    </div>
                </div>

                {{-- Status Pesanan --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl p-4 sm:p-6 shadow-md border border-gray-100 dark:border-gray-700">
                    <h2
                        class="text-base sm:text-lg font-bold mb-3 flex items-center text-orange-500 dark:text-gray-100">
                        🛵 Status Pesanan
                    </h2>
                    <div class="border-l-4 border-orange-500 pl-4">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="font-semibold text-sm sm:text-base text-gray-800 dark:text-gray-100">#00123
                                </p>
                                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Dalam Pengantaran 🛵</p>
                            </div>
                            <span
                                class="bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-400 px-2 py-1 rounded-full text-[10px] sm:text-xs">Aktif</span>
                        </div>
                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-3">Kurir: Budi</p>
                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-4">Estimasi: 10 menit ⏱️</p>
                        <button
                            class="w-full bg-orange-500 dark:bg-orange-600 text-white py-2 sm:py-2.5 rounded-lg text-xs sm:text-sm font-semibold hover:bg-orange-600 dark:hover:bg-orange-500 transition flex items-center justify-center gap-2">
                            📍Lacak Sekarang
                        </button>
                    </div>
                </div>
            </aside>
        </div>
    </main>
</x-app-layout>
