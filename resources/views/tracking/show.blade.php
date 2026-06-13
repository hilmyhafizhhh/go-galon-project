<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Lacak Pesanan · {{ $order->order_code }}</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
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
            --blue-mid: #dbeafe;
            --green: #16a34a;
            --green-lt: #f0fdf4;
            --amber: #d97706;
            --amber-lt: #fffbeb;
            --red: #dc2626;
            --surface: #ffffff;
            --bg: #f5f7ff;
            --border: #e8ecf4;
            --text-1: #0f172a;
            --text-2: #475569;
            --text-3: #94a3b8;
            --radius: 18px;
            --shadow: 0 2px 8px rgba(15, 23, 42, .07), 0 8px 28px rgba(15, 23, 42, .07);
        }

        html,
        body {
            height: 100%;
            font-family: 'Instrument Sans', sans-serif;
            background: var(--bg);
            color: var(--text-1);
            overflow-x: hidden;
        }

        /* ── Top bar ──────────────────────────────────── */
        .top-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 200;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: .85rem 1.1rem;
            display: flex;
            align-items: center;
            gap: .85rem;
        }

        .back-btn {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--bg);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-1);
            text-decoration: none;
            flex-shrink: 0;
            transition: background .15s;
        }

        .back-btn:hover {
            background: var(--border);
        }

        .back-btn svg {
            display: block;
        }

        .top-bar-info {
            flex: 1;
            min-width: 0;
        }

        .top-bar-title {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: .95rem;
            font-weight: 700;
            color: var(--text-1);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .top-bar-sub {
            font-size: .68rem;
            color: var(--text-3);
            margin-top: 1px;
        }

        /* Live indicator */
        .live-badge {
            display: flex;
            align-items: center;
            gap: .35rem;
            background: var(--green-lt);
            border: 1px solid #bbf7d0;
            border-radius: 999px;
            padding: .24rem .65rem;
            font-size: .65rem;
            font-weight: 700;
            color: var(--green);
            flex-shrink: 0;
        }

        .live-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #22c55e;
            animation: blink 1.8s ease-in-out infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: .4;
                transform: scale(1.5);
            }
        }

        /* ── Map ──────────────────────────────────────── */
        #map {
            position: fixed;
            top: 64px;
            left: 0;
            right: 0;
            /* height set by JS based on sheet */
            z-index: 10;
            transition: height .4s cubic-bezier(.4, 0, .2, 1);
        }

        /* ── Bottom sheet ─────────────────────────────── */
        .sheet {
            height: calc(100vh - 64px);
            transform: translateY(calc(100% - 220px));
        }

        /* drag handle */
        .sheet-handle {
            width: 36px;
            height: 4px;
            background: var(--border);
            border-radius: 999px;
            margin: .85rem auto .6rem;
            cursor: grab;
            flex-shrink: 0;
        }

        /* ── Status banner ────────────────────────────── */
        .status-banner {
            margin: 0 1.1rem .9rem;
            background: linear-gradient(135deg, var(--blue-lt), #e0e7ff);
            border: 1px solid var(--blue-mid);
            border-radius: 14px;
            padding: .85rem 1rem;
            display: flex;
            align-items: center;
            gap: .85rem;
        }

        .status-banner.delivered {
            background: linear-gradient(135deg, var(--green-lt), #dcfce7);
            border-color: #bbf7d0;
        }

        .status-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            flex-shrink: 0;
            background: #fff;
        }

        .status-text-wrap {
            flex: 1;
            min-width: 0;
        }

        .status-title {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: .9rem;
            font-weight: 700;
            color: var(--text-1);
        }

        .status-sub {
            font-size: .7rem;
            color: var(--text-2);
            margin-top: 2px;
        }

        /* ── Progress steps ───────────────────────────── */
        .progress-wrap {
            padding: 0 1.1rem .95rem;
        }

        .progress-title {
            font-size: .6rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--text-3);
            margin-bottom: .75rem;
        }

        .steps {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .step {
            display: flex;
            align-items: flex-start;
            gap: .75rem;
            position: relative;
        }

        .step:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 14px;
            top: 28px;
            width: 1.5px;
            height: calc(100% - 4px);
            background: var(--border);
            z-index: 0;
        }

        .step.done:not(:last-child)::after {
            background: var(--blue);
        }

        .step-dot {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: .7rem;
            border: 2px solid var(--border);
            background: var(--surface);
            z-index: 1;
            position: relative;
            transition: all .3s;
        }

        .step.done .step-dot {
            background: var(--blue);
            border-color: var(--blue);
            color: #fff;
        }

        .step.active .step-dot {
            background: var(--surface);
            border-color: var(--blue);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .12);
        }

        .step.active .step-dot-inner {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--blue);
            animation: blink 1.4s ease-in-out infinite;
        }

        .step-body {
            padding: .25rem 0 1rem;
        }

        .step-label {
            font-size: .8rem;
            font-weight: 600;
            color: var(--text-1);
            line-height: 1.3;
        }

        .step.pending-step .step-label {
            color: var(--text-3);
        }

        .step-time {
            font-size: .67rem;
            color: var(--text-3);
            margin-top: 2px;
        }

        /* ── Info rows ────────────────────────────────── */
        .divider {
            height: 1px;
            background: var(--border);
            margin: 0 1.1rem .95rem;
        }

        .info-section {
            padding: 0 1.1rem;
        }

        .info-section-title {
            font-size: .6rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--text-3);
            margin-bottom: .65rem;
        }

        .info-row {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .6rem 0;
            border-bottom: 1px solid var(--border);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-icon-wrap {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .info-icon-wrap.blue {
            background: var(--blue-lt);
        }

        .info-icon-wrap.green {
            background: var(--green-lt);
        }

        .info-icon-wrap.amber {
            background: var(--amber-lt);
        }

        .info-label {
            font-size: .62rem;
            color: var(--text-3);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .info-value {
            font-size: .82rem;
            font-weight: 600;
            color: var(--text-1);
            margin-top: 2px;
        }

        /* ── Route stats ──────────────────────────────── */
        .route-stats {
            display: none;
            grid-template-columns: 1fr 1px 1fr 1px 1fr;
            gap: 0;
            margin: 0 1.1rem .95rem;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
        }

        .route-stats.show {
            display: grid;
        }

        .rs-item {
            text-align: center;
            padding: .75rem .5rem;
        }

        .rs-sep {
            background: var(--border);
        }

        .rs-val {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: .95rem;
            font-weight: 700;
            color: var(--text-1);
        }

        .rs-lbl {
            font-size: .58rem;
            color: var(--text-3);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .07em;
            margin-top: 3px;
        }

        /* ── WA button ────────────────────────────────── */
        .wa-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            margin: 0 1.1rem 1.5rem;
            padding: .78rem 1rem;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 13px;
            color: var(--green);
            font-size: .82rem;
            font-weight: 700;
            text-decoration: none;
            transition: background .15s;
        }

        .wa-btn:hover {
            background: #dcfce7;
        }

        /* ── Leaflet overrides ────────────────────────── */
        .leaflet-control-zoom a {
            background: var(--surface) !important;
            color: var(--text-1) !important;
            border-color: var(--border) !important;
        }

        .leaflet-control-zoom a:hover {
            background: var(--bg) !important;
        }

        .leaflet-popup-content-wrapper {
            border-radius: 12px !important;
            border: 1px solid var(--border) !important;
            box-shadow: var(--shadow) !important;
        }

        .leaflet-popup-content {
            font-family: 'Instrument Sans', sans-serif;
            font-size: .8rem;
            font-weight: 600;
            color: var(--text-1);
        }

        .leaflet-control-attribution {
            font-size: .56rem !important;
            background: rgba(255, 255, 255, .8) !important;
        }

        /* ── Recenter FAB ─────────────────────────────── */
        .fab-recenter {
            position: fixed;
            right: 1rem;
            z-index: 50;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--surface);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background .15s, transform .15s;
            color: var(--blue);
        }

        .fab-recenter:hover {
            background: var(--blue-lt);
        }

        .fab-recenter:active {
            transform: scale(.93);
        }

        .leaflet-marker-icon {
            transition: transform 0.15s linear;
        }
    </style>
</head>

<body>

    {{-- ── Top bar ── --}}
    <div class="top-bar">
        <a href="javascript:history.back()" class="back-btn" aria-label="Kembali">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div class="top-bar-info">
            <div class="top-bar-title">Lacak Pesanan</div>
            <div class="top-bar-sub">#{{ $order->order_code }}</div>
        </div>
        <div class="live-badge" id="live-badge">
            <div class="live-dot"></div>
            Live
        </div>
    </div>

    {{-- ── Map ── --}}
    <div id="map"></div>

    {{-- Recenter FAB --}}
    <button class="fab-recenter" id="btn-recenter" aria-label="Pusatkan peta" onclick="recenterMap()">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="3" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v3m0 14v3M2 12h3m14 0h3" />
        </svg>
    </button>

    {{-- ── Bottom sheet ── --}}
    <div class="sheet" id="sheet">
        <div class="sheet-handle"></div>

        {{-- Status banner --}}
        <div class="status-banner" id="status-banner">
            <div class="status-icon" id="status-icon">🛵</div>
            <div class="status-text-wrap">
                <div class="status-title" id="status-title">Dalam Pengantaran</div>
                <div class="status-sub" id="status-sub">Kurir sedang menuju lokasi Anda</div>
            </div>
        </div>

        {{-- Route stats --}}
        <div class="route-stats" id="route-stats">
            <div class="rs-item">
                <div class="rs-val" id="rs-dist">–</div>
                <div class="rs-lbl">Jarak</div>
            </div>
            <div class="rs-sep"></div>
            <div class="rs-item">
                <div class="rs-val" id="rs-eta">–</div>
                <div class="rs-lbl">Estimasi</div>
            </div>
            <div class="rs-sep"></div>
            <div class="rs-item">
                <div class="rs-val" id="rs-updated">–</div>
                <div class="rs-lbl">Diperbarui</div>
            </div>
        </div>

        {{-- Progress steps --}}
        <div class="progress-wrap">
            <div class="progress-title">Status Pengiriman</div>
            <div class="steps" id="steps">
                <div class="step done" id="step-confirmed">
                    <div class="step-dot">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="step-body">
                        <div class="step-label">Pesanan dikonfirmasi</div>
                        <div class="step-time">{{ $order->created_at->format('d M · H:i') }}</div>
                    </div>
                </div>

                <div class="step done" id="step-pickup">
                    <div class="step-dot">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="step-body">
                        <div class="step-label">Kurir mengambil barang</div>
                        <div class="step-time" id="pickup-time">–</div>
                    </div>
                </div>

                <div class="step active" id="step-delivery">
                    <div class="step-dot">
                        <div class="step-dot-inner"></div>
                    </div>
                    <div class="step-body">
                        <div class="step-label">Dalam pengantaran</div>
                        <div class="step-time" id="delivery-time">Sedang berjalan…</div>
                    </div>
                </div>

                <div class="step pending-step" id="step-done">
                    <div class="step-dot"></div>
                    <div class="step-body">
                        <div class="step-label">Pesanan diterima</div>
                        <div class="step-time">–</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="divider"></div>

        {{-- Info detail --}}
        <div class="info-section" style="margin-bottom:.95rem;">
            <div class="info-section-title">Detail Pengiriman</div>

            <div class="info-row">
                <div class="info-icon-wrap blue">👤</div>
                <div>
                    <div class="info-label">Kurir</div>
                    <div class="info-value" id="info-courier">Memuat…</div>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon-wrap green">📍</div>
                <div>
                    <div class="info-label">Alamat Pengiriman</div>
                    <div class="info-value">{{ $order->address->address ?? '-' }}</div>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon-wrap amber">📦</div>
                <div>
                    <div class="info-label">No. Pesanan</div>
                    <div class="info-value">#{{ $order->order_code }}</div>
                </div>
            </div>
        </div>

        <div class="divider"></div>

        {{-- WA Button --}}
        @php
            $courierPhone = $order->assignedCourier?->user?->phone ?? '';
            $wa = $courierPhone ? '62' . ltrim($courierPhone, '0') : null;
        @endphp
        @if($wa)
            <a href="https://wa.me/{{ $wa }}" target="_blank" class="wa-btn" style="margin-top:.95rem;">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                </svg>
                Hubungi Kurir via WhatsApp
            </a>
        @endif

        <div style="height:env(safe-area-inset-bottom,1rem)"></div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-rotatedmarker@0.2.0/leaflet.rotatedMarker.min.js"></script>
    <script>
        /* ═══════════════════════════════════════════════════════
           TRACKING PAGE — Customer POV  |  Production JS
        ═══════════════════════════════════════════════════════ */

        const ORDER_ID = '{{ $order->id }}';
        const DEST_LAT = {{ $order->address->latitude ?? 'null' }};
        const DEST_LNG = {{ $order->address->longitude ?? 'null' }};
        const DEPOT_LAT = -6.1413375;
        const DEPOT_LNG = 106.7869347;

        /* ── Layout: map height + FAB position ──────── */
        const SHEET_PEEK = 220; // px sheet visible saat collapsed

        function layoutMap() {
            const topH = document.querySelector('.top-bar').offsetHeight;
            const winH = window.innerHeight;
            const mapH = winH - topH - SHEET_PEEK;
            const mapEl = document.getElementById('map');
            mapEl.style.top = topH + 'px';
            mapEl.style.height = Math.max(mapH, 140) + 'px';

            const fab = document.getElementById('btn-recenter');
            fab.style.top = (topH + Math.max(mapH, 140) - 52) + 'px';
        }
        layoutMap();
        window.addEventListener('resize', () => { layoutMap(); map.invalidateSize(); });

        /* ── Leaflet init ───────────────────────────── */
        const map = L.map('map', { zoomControl: false, attributionControl: true })
            .setView(DEST_LAT && DEST_LNG ? [DEST_LAT, DEST_LNG] : [DEPOT_LAT, DEPOT_LNG], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19,
        }).addTo(map);

        L.control.zoom({ position: 'topright' }).addTo(map);

        /* ── Icon helper ────────────────────────────── */
        function mkIcon(emoji, color, size = 38) {
            return L.divIcon({
                className: '',
                html: `<div style="background:${color};width:${size}px;height:${size}px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:${Math.round(size * .48)}px;box-shadow:0 3px 12px rgba(0,0,0,.22);border:2.5px solid #fff;">${emoji}</div>`,
                iconSize: [size, size], iconAnchor: [size / 2, size / 2],
            });
        }

        //script baru tambahan
        // Animasi marker
        function animateMarker(marker, from, to, duration = 1000) {
            const start = performance.now();
            
            function frame(time) {
                const progress = Math.min((time - start) / duration, 1);
                
                // easing
                const ease = progress < 0.5
                ? 2 * progress * progress
                : -1 + (4 - 2 * progress) * progress;
                
                const lat = from.lat + (to.lat - from.lat) * ease;
                const lng = from.lng + (to.lng - from.lng) * ease;
                
                marker.setLatLng([lat, lng]);
                
                if (progress < 1) {
                    requestAnimationFrame(frame);
                }
            }
            
            requestAnimationFrame(frame);
        
        }
        
        // Hitung bearing
        function getBearing(start, end) {
            const lat1 = start.lat * Math.PI / 180;
            const lon1 = start.lng * Math.PI / 180;
            const lat2 = end.lat * Math.PI / 180;
            const lon2 = end.lng * Math.PI / 180;
            
            const dLon = lon2 - lon1;
            
            const y = Math.sin(dLon) * Math.cos(lat2);
            const x =
            Math.cos(lat1) * Math.sin(lat2) -
            Math.sin(lat1) * Math.cos(lat2) * Math.cos(dLon);
            
            return (Math.atan2(y, x) * 180 / Math.PI + 360) % 360;
        }

        /* ── Static markers ─────────────────────────── */
        // Depot
        L.marker([DEPOT_LAT, DEPOT_LNG], { icon: mkIcon('🏪', '#2563eb') })
            .addTo(map).bindPopup('<b>Toko / Depot</b>');

        // Tujuan (rumah customer)
        if (DEST_LAT && DEST_LNG) {
            L.marker([DEST_LAT, DEST_LNG], { icon: mkIcon('🏠', '#dc2626') })
                .addTo(map).bindPopup('<b>Lokasi Kamu</b>');
        }

        // Kurir — default di depot
        // const courierMarker = L.marker([DEPOT_LAT, DEPOT_LNG], {
        //     icon: mkIcon('🛵', '#16a34a', 42),
        //     zIndexOffset: 1000,
        // }).addTo(map).bindPopup('<b>Posisi Kurir</b>');

        //diganti dengan script baru
        const courierIcon = L.icon({
            iconUrl: '/assets/icons/kurir-efata.png',
            iconSize: [50, 64],
            iconAnchor: [25, 60],
            popupAnchor: [0, -60]
        });
        
        const courierMarker = L.marker([DEPOT_LAT, DEPOT_LNG], {
            icon: courierIcon,
            zIndexOffset: 1000,
        }).addTo(map).bindPopup('<b>Posisi Kurir</b>');

        // Fit bounds
        if (DEST_LAT && DEST_LNG) {
            map.fitBounds(
                L.latLngBounds([DEPOT_LAT, DEPOT_LNG], [DEST_LAT, DEST_LNG]),
                { padding: [56, 56] }
            );
        }

        /* ── Route (OSRM) ───────────────────────────── */
        let routeLayers = [];
        let lastOsrm = 0;

        function drawRoute(fLat, fLng, tLat, tLng, force = false) {
            const now = Date.now();
            if (!force && now - lastOsrm < 10000) return; // throttle 10s
            lastOsrm = now;

            fetch(`https://router.project-osrm.org/route/v1/driving/${fLng},${fLat};${tLng},${tLat}?overview=full&geometries=geojson`)
                .then(r => r.json())
                .then(data => {
                    if (!data.routes?.length) return;
                    const route = data.routes[0];
                    const coords = route.geometry.coordinates.map(c => [c[1], c[0]]);
                    const distKm = (route.distance / 1000).toFixed(1);
                    const etaMins = Math.ceil(route.duration / 60);

                    // Hapus layer lama
                    routeLayers.forEach(l => map.removeLayer(l));

                    // Glow
                    const glow = L.polyline(coords, {
                        color: 'rgba(37,99,235,.15)', weight: 10,
                        lineCap: 'round', lineJoin: 'round',
                    }).addTo(map);

                    // Rute utama biru solid
                    const line = L.polyline(coords, {
                        color: '#2563eb', weight: 4, opacity: .88,
                        lineCap: 'round', lineJoin: 'round',
                    }).addTo(map);

                    // Panah arah — titik kecil di sepanjang rute
                    const arrowDecorator = L.polyline(coords, {
                        color: '#fff', weight: 2, opacity: .6,
                        dashArray: '1, 18',
                        lineCap: 'round',
                    }).addTo(map);

                    routeLayers = [glow, line, arrowDecorator];

                    // Update stats
                    document.getElementById('rs-dist').textContent = distKm + ' km';
                    document.getElementById('rs-eta').textContent = etaMins + ' mnt';
                    document.getElementById('route-stats').classList.add('show');
                })
                .catch(() => {
                    // Fallback garis lurus
                    routeLayers.forEach(l => map.removeLayer(l));
                    const fb = L.polyline(
                        DEST_LAT && DEST_LNG
                            ? [[fLat, fLng], [DEST_LAT, DEST_LNG]]
                            : [[fLat, fLng], [tLat, tLng]],
                        { color: '#2563eb', weight: 3, opacity: .5, dashArray: '7,5' }
                    ).addTo(map);
                    routeLayers = [fb];
                });
        }

        // Rute awal depot → tujuan
        if (DEST_LAT && DEST_LNG) {
            drawRoute(DEPOT_LAT, DEPOT_LNG, DEST_LAT, DEST_LNG, true);
        }

        /* ── Recenter ───────────────────────────────── */
        function recenterMap() {
            const pos = courierMarker.getLatLng();
            if (DEST_LAT && DEST_LNG) {
                map.fitBounds(
                    L.latLngBounds(pos, [DEST_LAT, DEST_LNG]),
                    { padding: [56, 56], animate: true }
                );
            } else {
                map.setView(pos, 15, { animate: true });
            }
        }

        /* ── Polling tracker ────────────────────────── */
        let firstGps = true;

        //tambahan script baru
        let previousPosition = L.latLng(DEPOT_LAT, DEPOT_LNG);
        const COURIER_ICON_OFFSET = 180;

        function fetchTracking() {
            fetch(`/api/tracking/${ORDER_ID}`)
                .then(r => r.json())
                .then(data => {
                    /* ── Nama kurir ── */
                    if (data.courier_name && data.courier_name !== '-') {
                        document.getElementById('info-courier').textContent = data.courier_name;
                    }

                    /* ── Timestamp ── */
                    const updEl = document.getElementById('rs-updated');
                    if (data.updated_at && data.updated_at !== 'Belum ada data') {
                        updEl.textContent = data.updated_at;
                        document.getElementById('delivery-time').textContent = data.updated_at;
                    }

                    /* ── Posisi kurir ── */
                    if (data.courier_lat && data.courier_lng) {
                        const lat = parseFloat(data.courier_lat);
                        const lng = parseFloat(data.courier_lng);

                        // // Geser marker
                        // courierMarker.setLatLng([lat, lng]);

                        // // Update rute kurir → tujuan
                        // if (DEST_LAT && DEST_LNG) {
                        //     drawRoute(lat, lng, DEST_LAT, DEST_LNG);
                        // }

                        const newPosition = L.latLng(lat, lng);
                        
                        // Hitung arah gerakan
                        const bearing = getBearing(previousPosition, newPosition);
                        
                        // Putar marker agar menghadap arah perjalanan
                        if (courierMarker.setRotationAngle) {
                            courierMarker.setRotationAngle(
                                bearing + COURIER_ICON_OFFSET
                            );
                            courierMarker.setRotationOrigin("bottom bottom");
                        }
                        
                        // Animasi perpindahan marker
                        animateMarker(
                            courierMarker,
                            previousPosition,
                            newPosition,
                            4500   // polling 5 detik → animasi 4.5 detik
                        );
                        
                        // Simpan posisi sekarang
                        previousPosition = newPosition;

                        // Geser map secara halus mengikuti posisi kurir
                        if (!map.getBounds().contains(newPosition)) {
                            map.panTo(newPosition, {
                                animate: true,
                                duration: 1
                            });
                        }
                        
                        // Update rute kurir → tujuan
                        if (DEST_LAT && DEST_LNG) {
                            drawRoute(lat, lng, DEST_LAT, DEST_LNG);
                        }

                        // Auto-recenter hanya pertama kali ada GPS
                        if (firstGps) {
                            firstGps = false;
                            if (DEST_LAT && DEST_LNG) {
                                map.fitBounds(
                                    L.latLngBounds([lat, lng], [DEST_LAT, DEST_LNG]),
                                    { padding: [56, 56], animate: true }
                                );
                            }
                        }

                        document.getElementById('route-stats').classList.add('show');
                    } else {
                        // GPS belum ada — kurir masih di depot
                        document.getElementById('rs-updated').textContent = 'Di depot';
                    }

                    /* ── Order status update ── */
                    updateStatusUI(data.order_status);

                    /* ── Redirect jika selesai ── */
                    if (data.order_status === 'completed') {
                        setTimeout(() => {
                            window.location.href = '{{ route("customer.order") }}?tab=completed';
                        }, 2500);
                    }
                })
                .catch(err => console.warn('Tracking poll error:', err));
        }

        /* ── Status UI ──────────────────────────────── */
        function updateStatusUI(status) {
            const banner = document.getElementById('status-banner');
            const icon = document.getElementById('status-icon');
            const title = document.getElementById('status-title');
            const sub = document.getElementById('status-sub');
            const badge = document.getElementById('live-badge');

            if (status === 'completed') {
                banner.classList.add('delivered');
                icon.textContent = '🎉';
                title.textContent = 'Pesanan Diterima!';
                sub.textContent = 'Selamat menikmati pesanan Anda';
                badge.style.display = 'none';

                // Steps — semua done
                ['step-confirmed', 'step-pickup', 'step-delivery', 'step-done'].forEach(id => {
                    const s = document.getElementById(id);
                    s.className = 'step done';
                    s.querySelector('.step-dot').innerHTML = `<svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>`;
                });
                document.getElementById('step-done').querySelector('.step-time').textContent = 'Baru saja';

            } else if (status === 'on_delivery') {
                icon.textContent = '🛵';
                title.textContent = 'Dalam Pengantaran';
                sub.textContent = 'Kurir sedang menuju lokasi Anda';
            } else if (status === 'confirmed') {
                icon.textContent = '✅';
                title.textContent = 'Pesanan Dikonfirmasi';
                sub.textContent = 'Kurir sedang menyiapkan pesanan';
            }
        }

        /* ── Start polling ──────────────────────────── */
        fetchTracking();
        setInterval(fetchTracking, 5000);
    </script>
</body>

</html>