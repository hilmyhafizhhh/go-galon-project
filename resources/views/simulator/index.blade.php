<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GPS Simulator — Demo Mode</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Bricolage+Grotesque:wght@600;700;800&display=swap">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --blue: #2563eb;
            --blue-lt: #eff6ff;
            --blue-md: #dbeafe;
            --green: #16a34a;
            --green-lt: #f0fdf4;
            --red: #dc2626;
            --amber: #d97706;
            --surface: #ffffff;
            --bg: #f5f7ff;
            --border: #e8ecf4;
            --text-1: #0f172a;
            --text-2: #475569;
            --text-3: #94a3b8;
            --r: 14px;
            --shadow: 0 1px 4px rgba(15, 23, 42, .06), 0 4px 16px rgba(15, 23, 42, .07);
        }

        body {
            font-family: 'Instrument Sans', sans-serif;
            background: var(--bg);
            color: var(--text-1);
            min-height: 100vh;
        }

        /* ── Layout ── */
        .layout {
            display: grid;
            grid-template-columns: 340px 1fr;
            height: 100vh;
            overflow: hidden;
        }

        @media (max-width: 768px) {
            .layout {
                grid-template-columns: 1fr;
                grid-template-rows: auto 1fr;
            }

            .sidebar {
                max-height: 48vh;
                overflow-y: auto;
            }
        }

        /* ── Sidebar ── */
        .sidebar {
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 1.1rem 1.25rem .9rem;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            background: var(--surface);
            z-index: 10;
        }

        .sim-label {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
            border-radius: 999px;
            padding: .18rem .65rem;
            font-size: .62rem;
            font-weight: 700;
            letter-spacing: .05em;
            text-transform: uppercase;
            margin-bottom: .6rem;
        }

        .sidebar-title {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--text-1);
            line-height: 1.2;
            margin-bottom: .2rem;
        }

        .sidebar-sub {
            font-size: .72rem;
            color: var(--text-3);
        }

        .sidebar-body {
            padding: 1rem 1.25rem;
            flex: 1;
        }

        /* Task select */
        .field-label {
            font-size: .62rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--text-3);
            margin-bottom: .45rem;
            display: block;
        }

        .task-select {
            width: 100%;
            padding: .65rem .85rem;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: var(--r);
            font-size: .82rem;
            font-weight: 500;
            color: var(--text-1);
            font-family: 'Instrument Sans', sans-serif;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%2394a3b8' viewBox='0 0 24 24'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right .85rem center;
            cursor: pointer;
            transition: border-color .15s;
        }

        .task-select:focus {
            outline: none;
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .1);
        }

        /* Speed slider */
        .speed-wrap {
            margin-top: 1rem;
        }

        .speed-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: .45rem;
        }

        .speed-val {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: .95rem;
            font-weight: 700;
            color: var(--blue);
        }

        input[type=range] {
            width: 100%;
            accent-color: var(--blue);
            cursor: pointer;
        }

        /* Interval */
        .interval-wrap {
            margin-top: 1rem;
        }

        /* Info cards */
        .info-cards {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .55rem;
            margin-top: 1.1rem;
        }

        .info-card {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: var(--r);
            padding: .7rem .85rem;
            text-align: center;
        }

        .ic-val {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-1);
        }

        .ic-lbl {
            font-size: .58rem;
            color: var(--text-3);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .07em;
            margin-top: 2px;
        }

        /* Progress bar */
        .progress-wrap {
            margin-top: 1.1rem;
        }

        .progress-track {
            height: 6px;
            background: var(--border);
            border-radius: 999px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            width: 0%;
            background: var(--blue);
            border-radius: 999px;
            transition: width .3s ease;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            font-size: .65rem;
            color: var(--text-3);
            margin-top: .4rem;
        }

        /* Log */
        .log-wrap {
            margin-top: 1.1rem;
            border: 1px solid var(--border);
            border-radius: var(--r);
            overflow: hidden;
        }

        .log-header {
            background: var(--bg);
            padding: .5rem .85rem;
            font-size: .62rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--text-3);
            border-bottom: 1px solid var(--border);
        }

        .log-body {
            height: 120px;
            overflow-y: auto;
            padding: .5rem .85rem;
            font-size: .68rem;
            font-family: 'Courier New', monospace;
            color: var(--text-2);
            display: flex;
            flex-direction: column;
            gap: .2rem;
        }

        .log-entry {
            display: flex;
            gap: .5rem;
        }

        .log-time {
            color: var(--text-3);
            flex-shrink: 0;
        }

        .log-entry.ok .log-msg {
            color: var(--green);
        }

        .log-entry.err .log-msg {
            color: var(--red);
        }

        .log-entry.info .log-msg {
            color: var(--blue);
        }

        /* Buttons */
        .btn-row {
            display: flex;
            gap: .55rem;
            margin-top: 1.2rem;
        }

        .btn {
            flex: 1;
            padding: .72rem 1rem;
            border-radius: var(--r);
            border: none;
            font-size: .8rem;
            font-weight: 700;
            font-family: 'Instrument Sans', sans-serif;
            cursor: pointer;
            transition: all .18s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .4rem;
        }

        .btn:active {
            transform: scale(.97);
        }

        .btn:disabled {
            opacity: .5;
            cursor: not-allowed;
        }

        .btn-play {
            background: var(--blue);
            color: #fff;
            box-shadow: 0 2px 10px rgba(37, 99, 235, .3);
        }

        .btn-play:hover:not(:disabled) {
            background: #1d4ed8;
        }

        .btn-play.running {
            background: var(--red);
            box-shadow: 0 2px 10px rgba(220, 38, 38, .3);
        }

        .btn-reset {
            background: var(--bg);
            border: 1px solid var(--border);
            color: var(--text-2);
        }

        .btn-reset:hover:not(:disabled) {
            background: var(--border);
        }

        /* Step indicator */
        .step-indicator {
            margin-top: .85rem;
            text-align: center;
            font-size: .72rem;
            color: var(--text-2);
        }

        .step-indicator span {
            font-weight: 700;
            color: var(--text-1);
        }

        /* ── Map ── */
        #map {
            width: 100%;
            height: 100%;
        }

        /* Tracker link */
        .tracker-link {
            margin-top: 1rem;
            padding: .65rem .85rem;
            background: var(--blue-lt);
            border: 1px solid var(--blue-md);
            border-radius: var(--r);
            display: flex;
            align-items: center;
            gap: .5rem;
            font-size: .72rem;
            color: var(--blue);
            font-weight: 600;
            text-decoration: none;
        }

        .tracker-link:hover {
            background: var(--blue-md);
        }

        #tracker-link-wrap {
            display: none;
        }

        #tracker-link-wrap.show {
            display: block;
        }
    </style>
</head>

<body>
    <div class="layout">

        {{-- ── SIDEBAR ── --}}
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="sim-label">⚗️ Demo Mode</div>
                <div class="sidebar-title">GPS Simulator</div>
                <div class="sidebar-sub">Simulasi perjalanan kurir untuk presentasi TA</div>
            </div>

            <div class="sidebar-body">

                {{-- Task select --}}
                <label class="field-label" for="task-select">Pilih Task (status: picked_up)</label>
                <select class="task-select" id="task-select">
                    <option value="">— Pilih task —</option>
                    @foreach($tasks as $task)
                        <option value="{{ $task->id }}" data-order="{{ $task->order->order_code ?? '-' }}">
                            #{{ $task->order->order_code ?? $task->id }} —
                            {{ Str::limit($task->order->user->name ?? '-', 20) }}
                            ({{ Str::limit($task->order->address->address ?? '?', 28) }})
                        </option>
                    @endforeach
                </select>

                {{-- Tracker link --}}
                <div id="tracker-link-wrap">
                    <a href="#" id="tracker-link" target="_blank" class="tracker-link">
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        Buka halaman tracking customer →
                    </a>
                </div>

                {{-- Speed --}}
                <div class="speed-wrap">
                    <label class="field-label">Kecepatan Simulasi</label>
                    <div class="speed-row">
                        <span style="font-size:.72rem;color:var(--text-2);">Lambat</span>
                        <span class="speed-val" id="speed-label">30 km/h</span>
                        <span style="font-size:.72rem;color:var(--text-2);">Cepat</span>
                    </div>
                    <input type="range" id="speed-range" min="10" max="80" value="30" step="5">
                </div>

                {{-- Interval --}}
                <div class="interval-wrap">
                    <label class="field-label">Interval Update</label>
                    <div class="speed-row">
                        <span style="font-size:.72rem;color:var(--text-2);">0.5s</span>
                        <span class="speed-val" id="interval-label">1.5s</span>
                        <span style="font-size:.72rem;color:var(--text-2);">5s</span>
                    </div>
                    <input type="range" id="interval-range" min="500" max="5000" value="1500" step="500">
                </div>

                {{-- Info cards --}}
                <div class="info-cards">
                    <div class="info-card">
                        <div class="ic-val" id="ic-dist">–</div>
                        <div class="ic-lbl">Jarak Rute</div>
                    </div>
                    <div class="info-card">
                        <div class="ic-val" id="ic-eta">–</div>
                        <div class="ic-lbl">ETA Rute</div>
                    </div>
                    <div class="info-card">
                        <div class="ic-val" id="ic-steps">–</div>
                        <div class="ic-lbl">Titik Koordinat</div>
                    </div>
                    <div class="info-card">
                        <div class="ic-val" id="ic-sent">0</div>
                        <div class="ic-lbl">Terkirim</div>
                    </div>
                </div>

                {{-- Progress --}}
                <div class="progress-wrap">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.45rem;">
                        <label class="field-label" style="margin:0;">Progress Rute</label>
                        <span style="font-size:.7rem;color:var(--blue);font-weight:700;" id="pct-label">0%</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" id="progress-fill"></div>
                    </div>
                    <div class="progress-label">
                        <span id="step-info">Langkah 0 / –</span>
                        <span id="dist-remaining">– km tersisa</span>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="btn-row">
                    <button class="btn btn-play" id="btn-play" disabled onclick="toggleSim()">
                        ▶ Mulai Simulasi
                    </button>
                    <button class="btn btn-reset" id="btn-reset" onclick="resetSim()">
                        ↺ Reset
                    </button>
                </div>

                <div class="step-indicator" id="step-indicator">Pilih task terlebih dahulu</div>

                {{-- Log --}}
                <div class="log-wrap">
                    <div class="log-header">Log</div>
                    <div class="log-body" id="log-body"></div>
                </div>

            </div>
        </div>

        {{-- ── MAP ── --}}
        <div id="map"></div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        /* ═══════════════════════════════════════════════════════════
           GPS SIMULATOR — Production-grade demo tool
        ═══════════════════════════════════════════════════════════ */

        const CSRF = document.querySelector('meta[name="csrf-token"]').content;

        // State
        let routeCoords = [];   // [{lat, lng}, ...]
        let currentStep = 0;
        let simInterval = null;
        let isRunning = false;
        let currentTaskId = null;
        let currentOrderCode = null;

        // Map
        const map = L.map('map').setView([-6.1413375, 106.7869347], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors', maxZoom: 19
        }).addTo(map);

        // Markers
        let courierMarker = null;
        let destMarker = null;
        let depotMarker = null;
        let routeLayer = [];

        function mkIcon(emoji, color, size = 38) {
            return L.divIcon({
                className: '',
                html: `<div style="background:${color};width:${size}px;height:${size}px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:${Math.round(size * .46)}px;box-shadow:0 3px 10px rgba(0,0,0,.25);border:2.5px solid #fff;">${emoji}</div>`,
                iconSize: [size, size], iconAnchor: [size / 2, size / 2],
            });
        }

        /* ── Log helper ─────────────────────────────── */
        let sentCount = 0;
        function log(msg, type = 'info') {
            const body = document.getElementById('log-body');
            const el = document.createElement('div');
            el.className = `log-entry ${type}`;
            el.innerHTML = `<span class="log-time">${new Date().toLocaleTimeString('id-ID')}</span><span class="log-msg">${msg}</span>`;
            body.appendChild(el);
            body.scrollTop = body.scrollHeight;
        }

        /* ── Speed / interval controls ──────────────── */
        document.getElementById('speed-range').addEventListener('input', e => {
            document.getElementById('speed-label').textContent = e.target.value + ' km/h';
        });
        document.getElementById('interval-range').addEventListener('input', e => {
            const s = (parseInt(e.target.value) / 1000).toFixed(1);
            document.getElementById('interval-label').textContent = s + 's';
            if (isRunning) {
                clearInterval(simInterval);
                simInterval = setInterval(stepSim, parseInt(e.target.value));
            }
        });

        /* ── Task select ─────────────────────────────── */
        document.getElementById('task-select').addEventListener('change', async function () {
            const taskId = this.value;
            if (!taskId) return;

            currentTaskId = taskId;
            currentOrderCode = this.selectedOptions[0]?.dataset?.order ?? null;

            // Update tracker link
            if (currentOrderCode) {
                const linkWrap = document.getElementById('tracker-link-wrap');
                const link = document.getElementById('tracker-link');
                link.href = `/track/${currentOrderCode}`;
                linkWrap.classList.add('show');
            }

            document.getElementById('btn-play').disabled = true;
            document.getElementById('step-indicator').textContent = 'Memuat rute dari OSRM…';
            log('Memuat rute untuk task #' + taskId + '…', 'info');

            try {
                const res = await fetch('/simulator/route?task_id=' + taskId, {
                    headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
                });
                const data = await res.json();

                if (!data.success) throw new Error(data.message ?? 'Gagal load rute');

                routeCoords = data.coords; // [[lat,lng], ...]
                currentStep = 0;

                // Hapus layer lama
                routeLayer.forEach(l => map.removeLayer(l));
                if (courierMarker) map.removeLayer(courierMarker);
                if (destMarker) map.removeLayer(destMarker);
                if (depotMarker) map.removeLayer(depotMarker);

                // Gambar rute
                const glow = L.polyline(routeCoords, {
                    color: 'rgba(37,99,235,.15)', weight: 10, lineCap: 'round', lineJoin: 'round'
                }).addTo(map);
                const line = L.polyline(routeCoords, {
                    color: '#2563eb', weight: 4, opacity: .85, lineCap: 'round', lineJoin: 'round'
                }).addTo(map);
                routeLayer = [glow, line];

                // Markers
                depotMarker = L.marker([data.depot_lat, data.depot_lng], { icon: mkIcon('🏪', '#2563eb') }).addTo(map).bindPopup('<b>Depot</b>');
                destMarker = L.marker([data.dest_lat, data.dest_lng], { icon: mkIcon('🏠', '#dc2626') }).addTo(map).bindPopup('<b>Tujuan Customer</b>');
                courierMarker = L.marker(routeCoords[0], { icon: mkIcon('🛵', '#16a34a', 44), zIndexOffset: 1000 }).addTo(map).bindPopup('<b>Posisi Kurir</b>');

                map.fitBounds(L.latLngBounds(routeCoords), { padding: [48, 48] });

                // Update UI
                document.getElementById('ic-dist').textContent = data.dist_km ? data.dist_km + ' km' : '–';
                document.getElementById('ic-eta').textContent = data.eta_mins ? data.eta_mins + ' mnt' : '–';
                document.getElementById('ic-steps').textContent = routeCoords.length;
                document.getElementById('btn-play').disabled = false;
                document.getElementById('step-indicator').textContent = 'Rute dimuat. Siap simulasi!';
                updateProgress();

                if (data.fallback) {
                    log('⚠️ OSRM gagal, pakai garis lurus sebagai rute', 'err');
                } else {
                    log(`✓ Rute dimuat: ${routeCoords.length} titik, ${data.dist_km} km, ETA ${data.eta_mins} mnt`, 'ok');
                }

            } catch (err) {
                log('Error: ' + err.message, 'err');
                document.getElementById('step-indicator').textContent = 'Gagal memuat rute.';
            }
        });

        /* ── Progress ────────────────────────────────── */
        function updateProgress() {
            const total = routeCoords.length;
            const pct = total > 0 ? Math.round((currentStep / (total - 1)) * 100) : 0;
            document.getElementById('progress-fill').style.width = pct + '%';
            document.getElementById('pct-label').textContent = pct + '%';
            document.getElementById('step-info').textContent = `Langkah ${currentStep} / ${total - 1}`;
            document.getElementById('ic-sent').textContent = sentCount;

            // Jarak tersisa (approx)
            if (routeCoords.length > 1) {
                const remaining = routeCoords.length - 1 - currentStep;
                const totalPts = routeCoords.length - 1;
                const distTotal = parseFloat(document.getElementById('ic-dist').textContent) || 0;
                const distLeft = ((remaining / totalPts) * distTotal).toFixed(1);
                document.getElementById('dist-remaining').textContent = distLeft + ' km tersisa';
            }
        }

        /* ── Toggle sim ──────────────────────────────── */
        function toggleSim() {
            if (isRunning) pauseSim();
            else startSim();
        }

        function startSim() {
            if (!routeCoords.length || !currentTaskId) return;
            if (currentStep >= routeCoords.length - 1) {
                currentStep = 0; // restart
                sentCount = 0;
            }

            isRunning = true;
            const btn = document.getElementById('btn-play');
            btn.textContent = '⏸ Pause';
            btn.classList.add('running');

            const intervalMs = parseInt(document.getElementById('interval-range').value);
            simInterval = setInterval(stepSim, intervalMs);
            log('▶ Simulasi dimulai dari langkah ' + currentStep, 'info');
        }

        function pauseSim() {
            isRunning = false;
            clearInterval(simInterval);
            const btn = document.getElementById('btn-play');
            btn.textContent = '▶ Lanjutkan';
            btn.classList.remove('running');
            log('⏸ Simulasi dijeda di langkah ' + currentStep, 'info');
        }

        function resetSim() {
            pauseSim();
            currentStep = 0;
            sentCount = 0;
            if (routeCoords.length && courierMarker) {
                courierMarker.setLatLng(routeCoords[0]);
                map.setView(routeCoords[0], 14, { animate: true });
            }
            document.getElementById('btn-play').textContent = '▶ Mulai Simulasi';
            document.getElementById('btn-play').classList.remove('running');
            updateProgress();
            log('↺ Direset ke titik awal', 'info');
        }

        /* ── Step simulasi ───────────────────────────── */
        async function stepSim() {
            if (currentStep >= routeCoords.length) {
                pauseSim();
                document.getElementById('btn-play').textContent = '✓ Selesai';
                document.getElementById('step-indicator').textContent = '🎉 Simulasi selesai! Kurir sudah sampai tujuan.';
                log('✓ Simulasi selesai!', 'ok');
                return;
            }

            const [lat, lng] = routeCoords[currentStep];
            const speed = parseInt(document.getElementById('speed-range').value);

            // Geser marker di simulator
            courierMarker.setLatLng([lat, lng]);

            // Auto-pan map mengikuti kurir
            const mapBounds = map.getBounds();
            if (!mapBounds.contains([lat, lng])) {
                map.panTo([lat, lng], { animate: true });
            }

            // Inject ke server
            try {
                const res = await fetch('/simulator/inject', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        task_id: currentTaskId,
                        latitude: lat,
                        longitude: lng,
                        speed: speed,
                    }),
                });
                const data = await res.json();

                if (data.success) {
                    sentCount++;
                    if (sentCount % 5 === 0 || currentStep === 0) {
                        log(`→ [${currentStep}] lat:${lat.toFixed(5)}, lng:${lng.toFixed(5)}`, 'ok');
                    }
                } else {
                    log('Inject gagal: ' + (data.message ?? '?'), 'err');
                }
            } catch (e) {
                log('Network error: ' + e.message, 'err');
            }

            currentStep++;
            document.getElementById('step-indicator').textContent = `Langkah ${currentStep} / ${routeCoords.length - 1}`;
            updateProgress();
        }
    </script>
</body>

</html>