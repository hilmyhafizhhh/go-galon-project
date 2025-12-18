<x-app-layout>
    <main class="bg-gray-50 dark:bg-gray-950 min-h-screen transition-colors duration-300">
        {{-- HEADER KURIR --}}
        <div class="bg-gradient-to-r from-blue-600 to-cyan-500 text-white p-4 shadow-lg">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ auth()->user()->profile_photo_url ?? asset('img/courier-default.png') }}" alt="Profile"
                        class="w-12 h-12 rounded-full border-2 border-white object-cover">
                    <div>
                        <h2 class="text-lg font-bold">{{ auth()->user()->name }}</h2>
                        <p class="text-xs opacity-90">Kurir Aktif</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                    <span class="text-sm">Online</span>
                </div>
            </div>
        </div>

        {{-- RINGKASAN HARI INI --}}
        <div class="p-4 grid grid-cols-3 gap-3">
            <div class="bg-white rounded-xl p-4 text-center shadow-sm">
                <p class="text-2xl font-bold text-blue-600">{{ $todayTasks ?? 0 }}</p>
                <p class="text-xs text-gray-600">Total Tugas</p>
            </div>
            <div class="bg-white rounded-xl p-4 text-center shadow-sm">
                <p class="text-2xl font-bold text-green-600">{{ $completedToday ?? 0 }}</p>
                <p class="text-xs text-gray-600">Selesai</p>
            </div>
            <div class="bg-white rounded-xl p-4 text-center shadow-sm">
                <p class="text-2xl font-bold text-yellow-600">{{ $pendingToday ?? 0 }}</p>
                <p class="text-xs text-gray-600">Menunggu</p>
            </div>
        </div>

        {{-- DAFTAR TUGAS HARI INI --}}
        <div class="px-4 pb-20">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Tugas Hari Ini</h3>
            <div class="space-y-3">
                @forelse($tasks as $task)
                    <div
                        class="bg-white rounded-xl shadow-sm p-4 border-l-4 {{ $task->status == 'pending'
                            ? 'border-yellow-500'
                            : ($task->status == 'picked_up'
                                ? 'border-blue-500'
                                : 'border-green-500') }}">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="font-medium text-gray-900">#{{ $task->order->code }}</p>
                                <p class="text-sm text-gray-600">{{ $task->customer->name }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ Str::limit($task->order->address, 50) }}</p>
                            </div>
                            <span
                                class="px-2 py-1 text-xs font-medium rounded-full {{ $task->status == 'pending'
                                    ? 'bg-yellow-100 text-yellow-800'
                                    : ($task->status == 'picked_up'
                                        ? 'bg-blue-100 text-blue-800'
                                        : 'bg-green-100 text-green-800') }}">
                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                            </span>
                        </div>

                        <!-- Aksi Cepat -->
                        <div class="flex gap-2 mt-3">
                            @if ($task->status == 'pending')
                                <button onclick="pickupTask({{ $task->id }})"
                                    class="flex-1 bg-blue-600 text-white text-sm py-2 rounded-lg font-medium hover:bg-blue-700 transition">
                                    Ambil Barang
                                </button>
                            @elseif($task->status == 'picked_up')
                                <button onclick="deliverTask({{ $task->id }})"
                                    class="flex-1 bg-green-600 text-white text-sm py-2 rounded-lg font-medium hover:bg-green-700 transition">
                                    Antar ke Tujuan
                                </button>
                            @else
                                <button class="flex-1 bg-gray-200 text-gray-600 text-sm py-2 rounded-lg" disabled>
                                    Selesai
                                </button>
                            @endif

                            <!-- WhatsApp -->
                            <a href="https://wa.me/{{ $task->customer->phone_clean ?? '62' . ltrim($task->customer->phone, '0') }}"
                                target="_blank" class="px-3 py-2 bg-green-100 rounded-lg hover:bg-green-200 transition">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967..."></path>
                                </svg>
                            </a>

                            <!-- Map -->
                            <a href="{{ route('courier.task.map', $task->id) }}"
                                class="px-3 py-2 bg-blue-100 rounded-lg hover:bg-blue-200 transition">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 text-gray-500">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="text-lg">Tidak ada tugas hari ini</p>
                        <p class="text-sm mt-2">Nikmati hari kamu dulu</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</x-app-layout>
