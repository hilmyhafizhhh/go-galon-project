<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ __('Profil Saya') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-md p-6 space-y-6">

            {{-- Info User --}}
            <div class="flex items-center space-x-4">
                <div
                    class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-3xl font-bold">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h3 class="text-xl font-semibold">{{ $user->name }}</h3>
                    <p class="text-gray-500">{{ $user->email }}</p>
                </div>
            </div>

            <hr>

            {{-- Informasi Akun --}}
            <div>
                <h4 class="font-semibold text-gray-700 mb-3">Informasi Akun</h4>
                <div class="space-y-2 text-gray-700">
                    <p><span class="font-medium">Alamat:</span> {{ $user->alamat ?? '-' }}</p>
                    <p><span class="font-medium">No. Handphone:</span> {{ $user->no_hp ?? '-' }}</p>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="space-y-3">
                <a href="{{ route('profile.edit') }}"
                    class="block w-full bg-blue-600 text-white text-center py-2 rounded-xl font-semibold hover:bg-blue-700">
                    Ubah Profil
                </a>
                <a href="{{ route('orders.index') }}"
                    class="block w-full bg-gray-100 text-gray-700 text-center py-2 rounded-xl font-semibold hover:bg-gray-200">
                    Riwayat Transaksi
                </a>
                <a href="{{ route('payment-methods.index') }}"
                    class="block w-full bg-gray-100 text-gray-700 text-center py-2 rounded-xl font-semibold hover:bg-gray-200">
                    Metode Pembayaran
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
