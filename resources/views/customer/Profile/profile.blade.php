<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Saya') }}
        </h2>
    </x-slot>

    <div x-data="editProfile()" class="py-6 bg-gray-50 min-h-screen">
        <div class="max-w-md mx-auto bg-white rounded-2xl shadow-lg overflow-hidden">
            {{-- Header Profil --}}
            <div class="bg-gradient-to-r from-blue-500 to-cyan-400 p-6 text-white flex items-center space-x-4">
                <div class="relative">
                    <img src="{{ asset('assets/image/cowo1.png') }}" alt="User"
                        class="w-16 h-16 rounded-full border-2 border-white object-cover">
                    <div
                        class="absolute bottom-0 right-0 w-5 h-5 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold">{{ $user->name }}</h3>
                    <p class="text-sm text-blue-100">{{ $user->email }}</p>
                </div>
            </div>

            {{-- Informasi Akun --}}
            <div class="p-5 space-y-4 border-b">
                <h4 class="text-blue-600 font-semibold flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Informasi Akun
                </h4>

                <div class="text-sm text-gray-700 space-y-3">
                    <div>
                        <p class="font-medium">Nama Lengkap</p>
                        <p x-text="form.name"></p>
                    </div>
                    <div>
                        <p class="font-medium">Email</p>
                        <p x-text="form.email"></p>
                    </div>
                    <div>
                        <p class="font-medium">Alamat</p>
                        <p x-text="form.alamat || 'Belum diisi'"></p>
                    </div>
                    <div>
                        <p class="font-medium">No. Handphone</p>
                        <p x-text="form.phone || 'Belum diisi'"></p>
                    </div>
                </div>
            </div>

            {{-- Menu Aksi --}}
            <div class="divide-y">
                <button @click="open = true"
                    class="flex justify-between items-center w-full p-4 hover:bg-gray-50 transition">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span class="font-medium text-gray-800">Ubah Profil</span>
                    </div>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <a href="#" class="flex justify-between items-center w-full p-4 hover:bg-gray-50 transition">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span class="font-medium text-gray-800">Riwayat Transaksi</span>
                    </div>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                <a href="#" class="flex justify-between items-center w-full p-4 hover:bg-gray-50 transition">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        <span class="font-medium text-gray-800">Metode Pembayaran</span>
                    </div>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>

        {{-- Modal Edit Profil --}}
        <div x-show="open" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div @click.away="open = false" class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 relative">
                <button @click="open = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <h3 class="text-lg font-bold text-gray-900 mb-4">Edit Profil</h3>
                <form @submit.prevent="submitForm" class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" x-model="form.name" required
                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Email</label>
                        <input type="email" x-model="form.email" required
                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Alamat</label>
                        <textarea x-model="form.alamat" rows="3"
                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">No. Handphone</label>
                        <input type="text" x-model="form.phone"
                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-2.5 rounded-md font-medium hover:bg-blue-700 transition">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

        {{-- Notifikasi Berhasil
        <div x-show="success" x-transition
            class="fixed top-5 right-5 bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg shadow">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span class="font-medium">Perubahan Berhasil Disimpan</span>
            </div>
        </div>
    </div> --}}
        <!-- Toast Notifikasi -->
        <div x-data="{ show: false, message: '' }"
            class="toast fixed bottom-6 right-6 bg-green-600 text-white px-4 py-3 rounded-lg shadow-lg" x-show="show"
            x-transition x-cloak x-text="message">
        </div>


        {{-- Alpine.js --}}
        <script>
            function editProfile() {
                return {
                    open: false,
                    form: {
                        name: '{{ $user->name }}',
                        email: '{{ $user->email }}',
                        alamat: '{{ $user->alamat ?? '' }}',
                        phone: '{{ $user->no_hp ?? '' }}'
                    },

                    submitForm() {
                        fetch('{{ route('customer.profile.update') }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify(this.form)
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {

                                    this.open = false; // Tutup modal

                                    const toast = document.querySelector('.toast');
                                    toast.__x.$data.message = data.message;
                                    toast.__x.$data.show = true;

                                    setTimeout(() => {
                                        toast.__x.$data.show = false;
                                    }, 3000);
                                }
                            })
                            .catch(err => console.error("JSON PARSE ERROR:", err));
                    }

                }
            }
        </script>
</x-app-layout>
