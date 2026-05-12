<x-app-layout>
    <main class="courier-app">

        {{-- HEADER --}}
        <div class="courier-header">
            <div class="header-inner">
                <div class="header-left">
                    <div class="avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="header-name">{{ auth()->user()->name }}</div>
                        {{-- <div class="header-role">Kurir Aktif · Area Selatan</div> --}}
                    </div>
                </div>
                <div class="online-badge">
                    <div class="pulse-dot"></div>
                    <span>Online</span>
                </div>
            </div>
        </div>

        {{-- STATISTIK --}}
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-num blue">{{ $todayTasks ?? 0 }}</div>
                <div class="stat-label">Total Tugas</div>
            </div>
            <div class="stat-card">
                <div class="stat-num green">{{ $completedToday ?? 0 }}</div>
                <div class="stat-label">Selesai</div>
            </div>
            <div class="stat-card">
                <div class="stat-num amber">{{ $pendingToday ?? 0 }}</div>
                <div class="stat-label">Menunggu</div>
            </div>
        </div>

        {{-- DAFTAR TUGAS --}}
        <div class="task-section">
            <div class="section-title">Tugas Hari Ini</div>

            <div class="task-list">
                @forelse($tasks as $task)
                    <div class="task-card">
                        <div class="status-bar {{ $task->status }}"></div>
                        <div class="task-top">
                            <div class="task-header">
                                <div>
                                    <div class="task-code">#{{ $task->order->code }}</div>
                                    <div class="task-customer">{{ $task->customer->name }}</div>
                                    <div class="task-address">
                                        <svg width="13" height="13" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ Str::limit($task->order->address, 45) }}
                                    </div>
                                </div>
                                <span class="badge {{ $task->status }}">
                                    @if ($task->status == 'pending')
                                        Menunggu
                                    @elseif($task->status == 'picked_up')
                                        Diambil
                                    @else
                                        Selesai
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="card-divider"></div>

                        <div class="task-actions">
                            @if ($task->status == 'pending')
                                <button onclick="pickupTask({{ $task->id }})" class="btn-main pickup">
                                    <svg width="14" height="14" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" aria-hidden="true"
                                        style="vertical-align:-2px;margin-right:5px">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    Ambil Barang
                                </button>
                            @elseif($task->status == 'picked_up')
                                <button onclick="deliverTask({{ $task->id }})" class="btn-main deliver">
                                    <svg width="14" height="14" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" aria-hidden="true"
                                        style="vertical-align:-2px;margin-right:5px">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                    </svg>
                                    Antar ke Tujuan
                                </button>
                            @else
                                <button class="btn-main done" disabled>
                                    <svg width="14" height="14" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" aria-hidden="true"
                                        style="vertical-align:-2px;margin-right:5px">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Terkirim
                                </button>
                            @endif

                            <a href="https://wa.me/{{ $task->customer->phone_clean ?? '62' . ltrim($task->customer->phone, '0') }}"
                                target="_blank" class="btn-icon wa" aria-label="Hubungi via WhatsApp">
                                <svg width="19" height="19" fill="currentColor" viewBox="0 0 24 24"
                                    aria-hidden="true">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                </svg>
                            </a>

                            <a href="{{ route('courier.task.map', $task->id) }}" class="btn-icon map"
                                aria-label="Lihat peta">
                                <svg width="19" height="19" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg width="32" height="32" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" style="color:#b4b2a9">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <div class="empty-title">Tidak ada tugas hari ini</div>
                        <div class="empty-sub">Nikmati hari kamu dulu 😊</div>
                    </div>
                @endforelse
            </div>
        </div>

        <script>
            function pickupTask(taskId) {
                fetch(`/courier/tasks/${taskId}/pickup`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        }
                    })
                    .then(res => res.json())
                    .then(() => window.location.reload())
                    .catch(err => console.error(err));
            }

            function deliverTask(taskId) {
                fetch(`/courier/tasks/${taskId}/deliver`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        }
                    })
                    .then(res => res.json())
                    .then(() => window.location.reload())
                    .catch(err => console.error(err));
            }
        </script>
    </main>
</x-app-layout>
