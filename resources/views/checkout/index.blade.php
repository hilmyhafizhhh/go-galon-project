<x-app-layout>
    {{-- paste semua kode di sini --}}
    <div class="bg-gray-100 min-h-screen pb-28">

        {{-- Header --}}
        <div class="bg-white px-4 py-3 flex items-center gap-3 border-b border-gray-200">
            <a href="javascript:history.back()">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5M12 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="text-base font-semibold text-gray-800">Checkout</h2>
        </div>

        <div class="pt-2 space-y-2">

            {{-- Alamat Pengiriman --}}
            <div class="bg-white px-4 py-3">
                <div class="flex items-start justify-between gap-2">
                    <div class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <div>
                            @foreach ($addresses as $address)
                                <label class="flex items-start gap-3 mb-3 cursor-pointer border p-3 rounded-xl">

                                    <input type="radio" name="address_id" value="{{ $address->id }}" class="mt-1"
                                        {{ $address->is_default ? 'checked' : '' }}>

                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">
                                            {{ $address->label }}
                                        </p>

                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $address->address }}
                                        </p>
                                    </div>
                                </label>
                            @endforeach
                            <a href="#" class="text-xs text-blue-500">+ Tambah alamat baru</a>
                        </div>
                    </div>
                    <a href="#" class="text-xs text-red-500 font-medium flex-shrink-0">Ganti</a>
                </div>
                {{-- Dashed border seperti TikTok Shop --}}
                <div class="mt-3 border-t-2 border-dashed border-red-200"></div>
            </div>

            {{-- Produk --}}
            <div class="bg-white">
                <div class="px-4 pt-3 pb-1 flex items-center gap-2 border-b border-gray-100">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                    </svg>
                    <span class="text-sm font-medium text-gray-700">Daftar Produk</span>
                </div>

                @foreach ($order->items as $item)
                    <div class="flex items-start gap-3 px-4 py-3 border-b border-gray-50 last:border-0">
                        {{-- Gambar produk --}}
                        <div
                            class="w-16 h-16 rounded-lg border border-gray-100 bg-gray-50 flex-shrink-0 overflow-hidden">
                            @if ($item->product->image)
                                <img src="{{ asset('assets/icons/' . $item->product->image) }}"
                                    class="w-full h-full object-contain">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-800 line-clamp-2 leading-snug">{{ $item->product->name }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">x{{ $item->quantity }}</p>
                            <div class="flex items-center justify-between mt-1.5">
                                <span class="text-xs text-gray-400">
                                    Rp{{ number_format($item->product->price, 0, ',', '.') }} / pcs
                                </span>
                                <span class="text-sm font-semibold text-red-500">
                                    Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Ringkasan Biaya --}}
            <div class="bg-white px-4 py-3">
                <p class="text-sm font-semibold text-gray-800 mb-3">Ringkasan biaya</p>

                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Subtotal produk</span>
                        <span class="text-sm text-gray-800">
                            Rp{{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Ongkos kirim</span>
                        <span class="text-sm text-gray-800">Rp0</span>
                    </div>
                </div>

                <div class="border-t border-gray-100 mt-3 pt-3 flex justify-between items-center">
                    <span class="text-sm font-semibold text-gray-800">Total pembayaran</span>
                    <span class="text-base font-bold text-red-500">
                        Rp{{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}
                    </span>
                </div>
            </div>

        </div>

    </div>

    {{-- Footer sticky --}}
    <div
        class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-3 flex items-center justify-between z-50">
        <div>
            <p class="text-xs text-gray-400">Total</p>
            <p class="text-base font-bold text-red-500">
                Rp{{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}
            </p>
        </div>

        <form action="{{ route('customer.checkout.process') }}" method="POST">
            @csrf
            <button type="submit"
                class="bg-red-500 hover:bg-red-600 active:scale-95 transition text-white text-sm font-semibold px-8 py-3 rounded-xl">
                Buat Pesanan
            </button>
        </form>
    </div>
</x-app-layout>
