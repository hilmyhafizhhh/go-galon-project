{{-- resources/views/courier/profile/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profil Saya</h2>
    </x-slot>

    <div class="py-6 pb-24 lg:pb-6">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Card Profil Kurir --}}
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <!-- Header Biru -->
                <div class="bg-gradient-to-b from-blue-500 to-blue-600 pt-8 pb-14 px-6 text-center text-white relative">
                    <div class="relative inline-block">
                        <div
                            class="w-24 h-24 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto">
                            <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div
                            class="absolute bottom-0 right-0 w-6 h-6 bg-green-400 rounded-full border-4 border-blue-600">
                        </div>
                    </div>

                    <h3 class="mt-4 text-2xl font-bold">{{ $user->name }}</h3>
                    <p class="text-sm opacity-90">ID:
                        {{ $user->courier_id ?? 'KUR' . str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</p>
                    <p class="mt-1 pb-6 text-sm">Status: Online | Pesanan: {{ $user->active_orders ?? 3 }} Aktif</p>

                    {{-- <!-- Toggle Online/Offline -->
                    <div class="mt-4">
                        <button @click="toggleStatus"
                                :class="isOnline ? 'bg-orange-500 hover:bg-orange-600' : 'bg-green-500 hover:bg-green-600'"
                                class="inline-flex items-center gap-2 px-5 py-2 rounded-full text-white font-medium transition">
                            <span class="w-10 h-5 bg-white/30 rounded-full relative inline-block">
                                <span :class="isOnline ? 'translate-x-5' : 'translate-x-0'" 
                                      class="absolute inset-y-0 w-5 h-5 bg-white rounded-full shadow transform transition"></span>
                            </span>
                            <span x-text="isOnline ? 'Toggle Offline' : 'Toggle Online'"></span>
                        </button>
                    </div> --}}

                    <!-- Tombol Edit (di kanan atas header) -->
                    {{-- <button @click="editMode = true"
                        class="absolute top-4 right-4 bg-white/20 backdrop-blur-sm hover:bg-white/30 px-4 py-2 rounded-lg text-white font-medium text-sm transition">
                        Edit Profil
                    </button>
                </div> --}}

                <!-- Bagian Informasi (selalu tampil) -->
                <div class="p-6 bg-gray-50 rounded-lg">
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nama Lengkap</span>
                            <span class="text-gray-600 font-medium">{{ $user->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Username</span>
                            <span class=" text-gray-600 font-medium">{{ $user->username ?? 'Belum diisi' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email</span>
                            <span class=" text-gray-600 font-medium text-right">{{ $user->email ?? 'Belum diisi' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- FORM EDIT - HIDDEN DULU
    <div x-data="courierProfile()" x-show="editMode" x-transition.opacity
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
        @keydown.escape.window="editMode = false">
        <div @click.away="editMode = false" class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 relative">
            <button @click="editMode = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <h3 class="text-xl font-bold text-gray-800 mb-6">Edit Profil</h3>

            <form @submit.prevent="submit" class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" x-model="form.name" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Handphone</label>
                    <input type="text" x-model="form.phone"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea x-model="form.alamat" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" @click="editMode = false"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-3 rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition shadow-lg">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div> --}}

{{-- Alpine Script --}}

{{-- <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script> --}}
    <script>
        function courierProfile() {
            return {
                editMode: false,
                isOnline: true,
                form: {
                    name: '{{ addslashes($user->name) }}',
                    phone: '{{ $user->no_hp ?? '' }}',
                    alamat: '{{ addslashes($user->alamat ?? '') }}'
                },

                toggleStatus() {
                    this.isOnline = !this.isOnline;
                    // Bisa kirim ke server nanti
                },

                submit() {
                    fetch('{{ route('courier.profile.update') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(this.form)
                        })
                        .then(r => r.json())
                        .then(res => {
                            if (res.success) {
                                this.editMode = false;
                                location.reload();
                            }
                        })
                        .catch(() => alert('Gagal menyimpan'));
                }
            }
        }
    </script>
</x-app-layout>
