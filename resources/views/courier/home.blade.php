<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        .courier-app {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f0f4ff;
            min-height: 100vh;
            padding-bottom: 2rem;
            color: #1e2d5a;
        }

        .courier-header {
            background: linear-gradient(135deg, #1a56db 0%, #1e40af 100%);
            padding: 1.25rem 1.25rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .header-inner { display:flex; justify-content:space-between; align-items:center; max-width:480px; margin:0 auto; }
        .header-left  { display:flex; align-items:center; gap:.75rem; }
        .avatar {
            width:44px; height:44px; background:rgba(255,255,255,.2);
            border:2px solid rgba(255,255,255,.35); border-radius:14px;
            display:flex; align-items:center; justify-content:center;
            font-weight:800; font-size:.85rem; color:#fff; letter-spacing:.05em;
        }
        .header-name { font-weight:700; font-size:1rem; color:#fff; }
        .header-sub  { font-size:.72rem; color:rgba(255,255,255,.6); margin-top:1px; }
        .online-badge {
            display:flex; align-items:center; gap:.4rem;
            background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.25);
            border-radius:999px; padding:.3rem .75rem;
            font-size:.73rem; font-weight:600; color:#fff;
        }
        .pulse-dot {
            width:7px; height:7px; background:#4ade80;
            border-radius:50%; animation:pulse 1.8s infinite; flex-shrink:0;
        }
        @keyframes pulse {
            0%,100% { opacity:1; transform:scale(1); }
            50%      { opacity:.5; transform:scale(1.4); }
        }

        /* STATS */
        .stats-wrap { max-width:480px; margin:0 auto; padding:0 1.25rem; transform:translateY(-1px); }
        .stats-grid {
            display:grid; grid-template-columns:repeat(3,1fr); gap:.65rem;
            background:#fff; border-radius:18px; padding:1rem .85rem;
            box-shadow:0 4px 20px rgba(30,64,175,.12);
        }
        .stat-card { text-align:center; position:relative; }
        .stat-card:not(:last-child)::after {
            content:''; position:absolute; right:0; top:20%; bottom:20%;
            width:1px; background:#e5e7eb;
        }
        .stat-num { font-size:1.9rem; font-weight:800; line-height:1; margin-bottom:.2rem; }
        .stat-num.blue  { color:#1a56db; }
        .stat-num.green { color:#059669; }
        .stat-num.amber { color:#d97706; }
        .stat-label { font-size:.67rem; color:#9ca3af; font-weight:600; letter-spacing:.05em; text-transform:uppercase; }

        /* SECTION */
        .task-section { padding:1.25rem 1.25rem .5rem; max-width:480px; margin:0 auto; }
        .section-title { font-size:.7rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:#9ca3af; margin-bottom:.85rem; }
        .task-list { display:flex; flex-direction:column; gap:.75rem; }

        /* TASK CARD */
        .task-card {
            background:#fff; border-radius:18px; overflow:hidden;
            box-shadow:0 2px 12px rgba(30,64,175,.07);
            border:1px solid rgba(30,64,175,.08);
            transition:transform .15s, box-shadow .15s;
        }
        .task-card:active { transform:scale(.99); }

        .status-strip { height:3px; width:100%; }
        .status-strip.pending   { background:linear-gradient(90deg,#f59e0b,#fbbf24); }
        .status-strip.picked_up { background:linear-gradient(90deg,#1a56db,#60a5fa); }
        .status-strip.completed { background:linear-gradient(90deg,#059669,#34d399); }

        .task-body { padding:1rem 1rem .85rem; }
        .task-top-row { display:flex; justify-content:space-between; align-items:flex-start; gap:.5rem; }
        .task-code     { font-size:.72rem; font-weight:700; color:#9ca3af; letter-spacing:.05em; margin-bottom:.2rem; }
        .task-customer { font-size:1rem; font-weight:700; color:#1e2d5a; }

        .badge {
            font-size:.63rem; font-weight:700; padding:.25rem .65rem;
            border-radius:999px; letter-spacing:.03em; text-transform:uppercase;
            flex-shrink:0; margin-top:2px; white-space:nowrap;
        }
        .badge.pending   { background:#fef3c7; color:#b45309; border:1px solid #fde68a; }
        .badge.picked_up { background:#dbeafe; color:#1d4ed8; border:1px solid #bfdbfe; }
        .badge.completed { background:#d1fae5; color:#065f46; border:1px solid #a7f3d0; }

        .task-address {
            display:flex; align-items:flex-start; gap:.35rem;
            font-size:.77rem; color:#6b7280; margin-top:.4rem; line-height:1.45;
        }
        .task-address svg { flex-shrink:0; margin-top:1px; color:#1a56db; }

        .card-divider { height:1px; background:#f3f4f6; margin:0 1rem; }

        /* ACTION ROW */
        .task-actions { display:flex; gap:.6rem; align-items:center; padding:.75rem 1rem; }

        .btn-main {
            flex:1; display:flex; align-items:center; justify-content:center; gap:.4rem;
            padding:.65rem 1rem; border-radius:12px; font-size:.82rem; font-weight:700;
            border:none; cursor:pointer; transition:all .2s ease; letter-spacing:.02em;
            font-family:'Plus Jakarta Sans',sans-serif;
        }
        .btn-main:active  { transform:scale(.97); }
        .btn-main:disabled { opacity:.6; cursor:not-allowed; }

        .btn-main.pickup  { background:linear-gradient(135deg,#1a56db,#2563eb); color:#fff; box-shadow:0 4px 14px rgba(26,86,219,.3); }
        .btn-main.deliver { background:linear-gradient(135deg,#059669,#10b981); color:#fff; box-shadow:0 4px 14px rgba(5,150,105,.25); }
        .btn-main.show-map {
            background:linear-gradient(135deg,#7c3aed,#8b5cf6);
            color:#fff; box-shadow:0 4px 14px rgba(124,58,237,.3);
        }
        .btn-main.done    { background:#f9fafb; color:#9ca3af; cursor:default; border:1px solid #e5e7eb; }

        .btn-icon {
            width:40px; height:40px; border-radius:12px;
            display:flex; align-items:center; justify-content:center;
            flex-shrink:0; transition:all .2s ease; text-decoration:none; border:none; cursor:pointer;
        }
        .btn-icon:active { transform:scale(.93); }
        .btn-icon.wa  { background:#dcfce7; color:#16a34a; border:1px solid #bbf7d0; }

        /* ── MAP PANEL ── */
        .map-panel {
            display:none;
            flex-direction:column;
        }
        .map-panel.open { display:flex; }

        .map-info-bar {
            background:#eff6ff;
            padding:.55rem 1rem;
            font-size:.75rem; color:#1e40af; font-weight:600;
            display:flex; align-items:center; gap:.4rem;
            border-top:1px solid #bfdbfe;
        }
        .gps-indicator {
            width:8px; height:8px; border-radius:50%;
            background:#9ca3af; flex-shrink:0; transition:background .3s;
        }
        .gps-indicator.active { background:#4ade80; animation:pulse 1.8s infinite; }

        .map-container { height:240px; width:100%; }

        /* Konfirmasi terkirim — muncul di bawah peta */
        .map-confirm-bar {
            padding:.75rem 1rem;
            background:#f0fdf4;
            border-top:1px solid #bbf7d0;
            display:flex;
            flex-direction:column;
            gap:.5rem;
        }
        .confirm-hint {
            font-size:.72rem; color:#059669; font-weight:600;
            display:flex; align-items:center; gap:.35rem;
        }
        .btn-confirm-deliver {
            width:100%;
            display:flex; align-items:center; justify-content:center; gap:.5rem;
            padding:.75rem 1rem;
            background:linear-gradient(135deg,#059669,#10b981);
            color:#fff; font-size:.88rem; font-weight:700;
            border:none; border-radius:12px; cursor:pointer;
            font-family:'Plus Jakarta Sans',sans-serif;
            box-shadow:0 4px 14px rgba(5,150,105,.3);
            transition:all .2s ease;
        }
        .btn-confirm-deliver:active  { transform:scale(.98); }
        .btn-confirm-deliver:disabled { opacity:.6; cursor:not-allowed; }

        /* EMPTY */
        .empty-state {
            text-align:center; padding:3.5rem 1rem;
            background:#fff; border:1px dashed #bfdbfe; border-radius:20px;
        }
        .empty-icon {
            width:64px; height:64px; background:#eff6ff; border-radius:18px;
            display:flex; align-items:center; justify-content:center; margin:0 auto 1rem;
        }
        .empty-title { font-size:1rem; font-weight:700; color:#374151; margin-bottom:.35rem; }
        .empty-sub   { font-size:.82rem; color:#9ca3af; }

        /* TOAST */
        .toast-wrap {
            position:fixed; bottom:1.5rem; left:50%; transform:translateX(-50%);
            z-index:999; display:flex; flex-direction:column; gap:.5rem;
            align-items:center; pointer-events:none;
        }
        .toast {
            background:#1e2d5a; color:#fff; font-size:.82rem; font-weight:600;
            padding:.6rem 1.25rem; border-radius:999px;
            box-shadow:0 8px 24px rgba(30,45,90,.25);
            opacity:0; transform:translateY(8px); transition:all .3s ease;
            pointer-events:none; font-family:'Plus Jakarta Sans',sans-serif;
        }
        .toast.show    { opacity:1; transform:translateY(0); }
        .toast.success { background:#065f46; }
        .toast.error   { background:#991b1b; }
        .toast.info    { background:#1e40af; }
    </style>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    <main class="courier-app">

        {{-- HEADER --}}
        <div class="courier-header">
            <div class="header-inner">
                <div class="header-left">
                    <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                    <div>
                        <div class="header-name">{{ auth()->user()->name }}</div>
                        <div class="header-sub">Kurir Aktif</div>
                    </div>
                </div>
                <div class="online-badge">
                    <div class="pulse-dot"></div>
                    <span>Online</span>
                </div>
            </div>
        </div>

        {{-- STATISTIK --}}
        <div class="stats-wrap">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-num blue">{{ $todayTasks ?? 0 }}</div>
                    <div class="stat-label">Total</div>
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
        </div>

        {{-- DAFTAR TUGAS --}}
        <div class="task-section">
            <div class="section-title">Tugas Hari Ini</div>

            <div class="task-list">
                @forelse($tasks as $task)
                    @php
                        $destLat = $task->order->address->latitude ?? null;
                        $destLng = $task->order->address->longitude ?? null;
                        $phone = $task->order->user->phone ?? '';
                        $wa = '62' . ltrim($phone, '0');
                    @endphp

                    <div class="task-card" id="card-{{ $task->id }}">
                        <div class="status-strip {{ $task->status }}"></div>

                        <div class="task-body">
                            <div class="task-top-row">
                                <div>
                                    <div class="task-code">{{ $task->order->order_code ?? '-' }}</div>
                                    <div class="task-customer">{{ $task->order->user->name ?? '-' }}</div>
                                    <div class="task-address">
                                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ Str::limit($task->order->address->address ?? '-', 52) }}
                                    </div>
                                </div>
                                <span class="badge {{ $task->status }}">
                                    @if($task->status == 'pending') Menunggu
                                    @elseif($task->status == 'picked_up') Diantar
                                    @else Selesai
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="card-divider"></div>

                        {{-- ACTION BUTTONS --}}
                        <div class="task-actions">
                            @if($task->status == 'pending')

                                {{-- Ambil Barang --}}
                                <button onclick="pickupTask({{ $task->id }}, this)" class="btn-main pickup">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    Ambil Barang
                                </button>

                            @elseif($task->status == 'picked_up')

                                {{-- 
                                    "Mulai Antar" → buka peta + aktifkan GPS
                                    Tombol "Konfirmasi Terkirim" ada DI DALAM map panel (lihat bawah)
                                --}}
                                <button onclick="openDeliveryMap({{ $task->id }}, {{ $destLat ?? 'null' }}, {{ $destLng ?? 'null' }})"
                                    class="btn-main show-map" id="btn-start-{{ $task->id }}">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                    </svg>
                                    Mulai Antar
                                </button>

                            @else
                                <button class="btn-main done" disabled>
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Terkirim
                                </button>
                            @endif

                            {{-- WhatsApp --}}
                            <a href="https://wa.me/{{ $wa }}" target="_blank" class="btn-icon wa" aria-label="WhatsApp">
                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                            </a>
                        </div>

                        {{-- 
                            MAP PANEL — hanya muncul saat picked_up dan kurir tekan "Mulai Antar"
                            Di dalamnya ada tombol "Konfirmasi Terkirim" yang sesungguhnya
                        --}}
                        @if($task->status == 'picked_up')
                            <div class="map-panel" id="map-panel-{{ $task->id }}">
                                {{-- GPS status bar --}}
                                <div class="map-info-bar">
                                    <div class="gps-indicator" id="gps-dot-{{ $task->id }}"></div>
                                    <span id="gps-label-{{ $task->id }}">Mengaktifkan GPS...</span>
                                </div>

                                {{-- Peta --}}
                                <div class="map-container" id="map-{{ $task->id }}"></div>

                                {{-- Konfirmasi di bawah peta --}}
                                <div class="map-confirm-bar">
                                    <div class="confirm-hint">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Tekan tombol di bawah setelah barang diserahkan ke customer
                                    </div>
                                    <button onclick="deliverTask({{ $task->id }}, this)"
                                        class="btn-confirm-deliver" id="btn-deliver-{{ $task->id }}">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Konfirmasi Sudah Terkirim
                                    </button>
                                </div>
                            </div>
                        @endif

                    </div>
                @empty
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg width="28" height="28" fill="none" stroke="#1a56db" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                        </div>
                        <div class="empty-title">Tidak ada tugas hari ini</div>
                        <div class="empty-sub">Santai dulu, pesanan belum masuk 😊</div>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="toast-wrap" id="toastWrap"></div>
    </main>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const DEPOT_LAT  = -6.1413375;
        const DEPOT_LNG  = 106.7869347;
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;

        const mapInstances   = {};
        const courierMarkers = {};
        const gpsIntervals   = {};

        // ── Toast ──────────────────────────────────────────────────────────
        function showToast(msg, type = 'success') {
            const wrap = document.getElementById('toastWrap');
            const t    = document.createElement('div');
            t.className  = 'toast ' + type;
            t.textContent = msg;
            wrap.appendChild(t);
            requestAnimationFrame(() => requestAnimationFrame(() => t.classList.add('show')));
            setTimeout(() => { t.classList.remove('show'); setTimeout(() => t.remove(), 350); }, 2800);
        }

        // ── Pickup ────────────────────────────────────────────────────────
        function pickupTask(taskId, btn) {
            btn.disabled  = true;
            btn.innerHTML = 'Memproses...';
            fetch(`/courier/tasks/${taskId}/pickup`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    showToast('✓ Barang berhasil diambil! Sekarang antar ke customer.', 'success');
                    setTimeout(() => location.reload(), 900);
                } else {
                    showToast('Gagal: ' + (data.message ?? 'Coba lagi'), 'error');
                    btn.disabled  = false;
                    btn.innerHTML = 'Ambil Barang';
                }
            })
            .catch(() => {
                showToast('Terjadi kesalahan', 'error');
                btn.disabled  = false;
                btn.innerHTML = 'Ambil Barang';
            });
        }

        // ── Buka peta pengiriman + aktifkan GPS ───────────────────────────
        function openDeliveryMap(taskId, destLat, destLng) {
    const panel    = document.getElementById('map-panel-' + taskId);
    const btnStart = document.getElementById('btn-start-' + taskId);

    if (!destLat || !destLng) {
        showToast('Alamat customer belum memiliki koordinat GPS', 'error');
        return;
    }

    // ✅ Tambahan: beritahu server bahwa kurir mulai antar
    fetch(`/courier/tasks/${taskId}/start-delivery`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        if (!data.success) {
            showToast('Gagal memulai pengiriman: ' + (data.message ?? ''), 'error');
            return;
        }

        panel.classList.add('open');
        if (btnStart) btnStart.style.display = 'none';

        if (!mapInstances[taskId]) {
            initMap(taskId, destLat, destLng);
        }

        setTimeout(() => panel.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 150);
        showToast('📍 GPS aktif — navigasi ke tujuan', 'info');
    })
    .catch(() => showToast('Terjadi kesalahan saat memulai pengiriman', 'error'));
}

        // ── Init Leaflet map ───────────────────────────────────────────────
        function initMap(taskId, destLat, destLng) {
            const map = L.map('map-' + taskId, { zoomControl: true }).setView([destLat, destLng], 14);
            mapInstances[taskId] = map;

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap',
                maxZoom: 19,
            }).addTo(map);

            // Marker depot
            L.marker([DEPOT_LAT, DEPOT_LNG], {
                icon: L.divIcon({
                    className: '',
                    html: `<div style="background:#1a56db;color:#fff;width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:16px;box-shadow:0 2px 8px rgba(0,0,0,.3);border:2px solid #fff;">🏪</div>`,
                    iconSize: [34,34], iconAnchor: [17,17],
                })
            }).addTo(map).bindPopup('<b>Depot / Toko</b>');

            // Marker tujuan customer
            L.marker([destLat, destLng], {
                icon: L.divIcon({
                    className: '',
                    html: `<div style="background:#dc2626;color:#fff;width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:16px;box-shadow:0 2px 8px rgba(0,0,0,.3);border:2px solid #fff;">📦</div>`,
                    iconSize: [34,34], iconAnchor: [17,17],
                })
            }).addTo(map).bindPopup('<b>Tujuan — Alamat Customer</b>');

            // Fit supaya depot + tujuan kelihatan
            map.fitBounds(
                L.latLngBounds([DEPOT_LAT, DEPOT_LNG], [destLat, destLng]),
                { padding: [40, 40] }
            );

            // Aktifkan GPS tracking
            startGpsTracking(taskId, destLat, destLng);
        }

        // ── GPS Tracking ───────────────────────────────────────────────────
        function startGpsTracking(taskId, destLat, destLng) {
            if (!navigator.geolocation) {
                document.getElementById('gps-label-' + taskId).textContent = 'GPS tidak tersedia di browser ini';
                return;
            }

            const dot   = document.getElementById('gps-dot-'   + taskId);
            const label = document.getElementById('gps-label-' + taskId);

            function sendPosition() {
                navigator.geolocation.getCurrentPosition(pos => {
                    const { latitude: lat, longitude: lng, speed: spd } = pos.coords;

                    // Update marker kurir di peta
                    updateCourierMarker(taskId, lat, lng);

                    // Kirim ke server
                    fetch(`/courier/tasks/${taskId}/location`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': CSRF_TOKEN,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ latitude: lat, longitude: lng, speed: spd }),
                    })
                    .then(r => r.json())
                    .then(d => {
                        if (d.success) {
                            dot.classList.add('active');
                            label.textContent = 'GPS aktif · ' + new Date().toLocaleTimeString('id-ID');
                        }
                    })
                    .catch(() => {
                        dot.classList.remove('active');
                        label.textContent = 'Gagal kirim lokasi, mencoba ulang...';
                    });

                }, err => {
                    dot.classList.remove('active');
                    label.textContent = 'GPS error: ' + err.message;
                }, { enableHighAccuracy: true, timeout: 8000, maximumAge: 0 });
            }

            sendPosition();
            gpsIntervals[taskId] = setInterval(sendPosition, 5000);
        }

        // ── Update marker kurir ────────────────────────────────────────────
        function updateCourierMarker(taskId, lat, lng) {
            const map = mapInstances[taskId];
            if (!map) return;

            const icon = L.divIcon({
                className: '',
                html: `<div style="background:#059669;color:#fff;width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:18px;box-shadow:0 2px 8px rgba(0,0,0,.3);border:3px solid #fff;">🛵</div>`,
                iconSize: [36,36], iconAnchor: [18,18],
            });

            if (courierMarkers[taskId]) {
                courierMarkers[taskId].setLatLng([lat, lng]);
            } else {
                courierMarkers[taskId] = L.marker([lat, lng], { icon }).addTo(map).bindPopup('<b>Posisi Anda</b>');
            }
        }

        // ── Deliver (konfirmasi terkirim) ──────────────────────────────────
        function deliverTask(taskId, btn) {
            if (!confirm('Konfirmasi: barang sudah diserahkan ke customer?')) return;

            btn.disabled  = true;
            btn.innerHTML = '⏳ Memproses...';

            fetch(`/courier/tasks/${taskId}/deliver`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    // Hentikan GPS
                    if (gpsIntervals[taskId]) {
                        clearInterval(gpsIntervals[taskId]);
                        delete gpsIntervals[taskId];
                    }
                    showToast('✅ Pesanan berhasil diantarkan!', 'success');
                    setTimeout(() => location.reload(), 900);
                } else {
                    showToast('Gagal: ' + (data.message ?? 'Coba lagi'), 'error');
                    btn.disabled  = false;
                    btn.innerHTML = 'Konfirmasi Sudah Terkirim';
                }
            })
            .catch(() => {
                showToast('Terjadi kesalahan', 'error');
                btn.disabled  = false;
                btn.innerHTML = 'Konfirmasi Sudah Terkirim';
            });
        }
    </script>
</x-app-layout>