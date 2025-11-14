<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Saya') }}
        </h2>
    </x-slot>

    <div x-data="editProfile()"
        class="py-6 bg-gray-50 min-h-screen opacity-0 translate-y-5 transition-all duration-700 ease-out"
        x-effect="$nextTick(() => $el.classList.remove('opacity-0', 'translate-y-5'))">
        <div
            class="max-w-md lg:max-w-5xl mx-auto bg-white rounded-2xl shadow-lg overflow-hidden lg:grid lg:grid-cols-2 lg:gap-0">
            {{-- Header Profil --}}
            <div
                class="bg-gradient-to-r from-blue-500 to-cyan-500 p-6 text-white flex flex-col justify-center items-center space-x-4">
                <div class="relative">
                    <img src="{{ asset('assets/image/cowo1.png') }}" alt="User"
                        class="w-24 h-24 lg:w-48 lg:h-48 rounded-full border-4 border-white object-cover">
                    <div
                        class="absolute bottom-0 right-0 w-5 h-5 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <div class="text-center lg:text-left">
                    <h3 class="text-xl font-bold">{{ $user->name }}</h3>
                    <p class="text-sm opacity-90">{{ $user->email }}</p>
                </div>
            </div>

            {{-- Informasi Akun --}}
            <div class="p-6 lg:p-8 space-y-6">
                <div class="space-y-4">
                    <h4 class="text-blue-600 font-semibold flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Informasi Akun
                    </h4>

                    <div class="text-sm text-gray-700 space-y-3 grid grid-cols-1 gap-3">
                        <div>
                            <p class="font-medium">Nama Lengkap</p>
                            <div class="flex justify-between items-center">
                                <p x-text="form.name"></p>
                                <img src="{{ asset('assets/icons/Note.svg') }}" alt="Note">
                            </div>
                        </div>
                        <div>
                            <p class="font-medium">Username</p>
                            <div class="flex justify-between items-center">
                                <p x-text="form.username"></p>
                                <img src="{{ asset('assets/icons/Note.svg') }}" alt="Note">
                            </div>
                        </div>
                        <div>
                            <p class="font-medium">Email</p>

                            <div class="items-center flex justify-between">
                                <p x-text="form.email"></p>
                                <img src="{{ asset('assets/icons/Email.svg') }}" alt="Email">
                            </div>
                        </div>
                        <div>
                            <p class="font-medium">Alamat</p>
                            <div class="flex justify-between items-center">
                                <p x-text="form.alamat || 'Belum diisi'"></p>
                                <div class="flex items-end gap-2">
                                    <img src="{{ asset('assets/icons/Group.svg') }}" alt="Location">
                                    <img src="{{ asset('assets/icons/Note.svg') }}" alt="Note" class="w-4 h-4">
                                </div>
                            </div>
                        </div>
                        <div>
                            <p class="font-medium">No. Handphone</p>
                            <div class="flex items-center justify-between">
                                <p x-text="form.phone || 'Belum diisi'"></p>
                                <img src="{{ asset('assets/icons/Phones.svg') }}" alt="Phone">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Menu Aksi --}}
            <div class="divide-y space-y-1">
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

                {{-- <a href="#" class="flex justify-between items-center w-full p-4 hover:bg-gray-50 transition">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        <span class="font-medium text-gray-800">Metode Pembayaran</span>
                    </div>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a> --}}
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
                        <label class="text-sm font-medium text-gray-700">Username</label>
                        <input type="text" x-model="form.username" required
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

        <script>
            function editProfile() {
                return {
                    open: false,
                    form: {
                        name: '{{ $user->name }}',
                        username: '{{ $user->username }}',
                        email: '{{ $user->email }}',
                        alamat: '{{ $user->alamat ?? '' }}',
                        phone: '{{ $user->no_hp ?? '' }}'
                    },


                    tampilkanPopup(pesan) {
                        const popup = document.createElement('div');
                        popup.innerHTML = `
    <div class="fixed top-24 right-24 lg:top-24 lg:right-24 left-1/2 -translate-x-1/2 lg:left-auto lg:translate-x-0 w-[85%] max-w-xs lg:w-auto bg-gradient-to-r from-blue-500 to-cyan-600 text-white px-4 py-2.5 lg:px-5 lg:py-3 rounded-xl shadow-2xl z-[9999] flex items-center gap-2 animate-popup font-medium text-sm lg:text-base">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span class="truncate">${pesan}</span>
    </div>
`;
                        document.body.appendChild(popup);
                        setTimeout(() => popup.remove(), 2200);
                    },

                    submitForm() {
                        const vm = this;

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
                                    // 1. Tutup modal
                                    vm.open = false;

                                    // 2. Update data di tampilan
                                    document.querySelector('[x-text="form.name"]').textContent = vm.form.name;
                                    document.querySelector('[x-text="form.email"]').textContent = vm.form.email;
                                    document.querySelector('[x-text="form.alamat || \'Belum diisi\'"]').textContent = vm
                                        .form.alamat || 'Belum diisi';
                                    document.querySelector('[x-text="form.phone || \'Belum diisi\'"]').textContent = vm.form
                                        .phone || 'Belum diisi';

                                    const navbarName = document.querySelector('.navbar-user-name');
                                    if (navbarName) {
                                        navbarName.textContent = vm.form.name;
                                    }

                                    // 3. TAMPILKAN POPUP JS MURNI
                                    vm.tampilkanPopup(data.message);
                                }
                            })
                            .catch(err => {
                                console.error(err);
                                vm.tampilkanPopup('Gagal memperbarui profil.');
                            });
                    }
                }
            }
        </script>
        <style>
            @keyframes popup {
                0% {
                    transform: translateY(-20px);
                    opacity: 0;
                }

                10% {
                    transform: translateY(0);
                    opacity: 1;
                }

                90% {
                    transform: translateY(0);
                    opacity: 1;
                }

                100% {
                    transform: translateY(-20px);
                    opacity: 0;
                }
            }

            .animate-popup {
                animation: popup 2.2s ease-out forwards;
            }
        </style>
</x-app-layout>
