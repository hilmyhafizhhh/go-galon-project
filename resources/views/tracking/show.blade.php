<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Pesanan #{{ $order->order_code }}</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f0f4ff;
            min-height: 100vh;
        }

        .track-header {
            background: linear-gradient(135deg, #1a56db, #1e40af);
            padding: 1rem 1.25rem;
            color: #fff;
        }

        .track-header h1 {
            font-size: 1rem;
            font-weight: 700;
        }

        .track-header p {
            font-size: .75rem;
            opacity: .7;
            margin-top: 2px;
        }

        .track-map {
            width: 100%;
            height: 55vh;
        }

        .track-info {
            background: #fff;
            border-radius: 20px 20px 0 0;
            margin-top: -16px;
            position: relative;
            z-index: 10;
            padding: 1.25rem;
            box-shadow: 0 -4px 20px rgba(30, 64, 175, .1);
        }

        .info-row {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .75rem 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .info-icon.blue {
            background: #eff6ff;
        }

        .info-icon.green {
            background: #f0fdf4;
        }

        .info-icon.orange {
            background: #fff7ed;
        }

        .info-label {
            font-size: .7rem;
            color: #9ca3af;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .info-value {
            font-size: .88rem;
            color: #1e2d5a;
            font-weight: 600;
            margin-top: 1px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            background: #fff7ed;
            color: #c2410c;
            border: 1px solid #fed7aa;
            border-radius: 999px;
            padding: .25rem .75rem;
            font-size: .72rem;
            font-weight: 700;
        }

        .pulse {
            width: 7px;
            height: 7px;
            background: #f97316;
            border-radius: 50%;
            animation: pulse 1.8s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1)
            }

            50% {
                opacity: .5;
                transform: scale(1.4)
            }
        }

        .updated-label {
            font-size: .68rem;
            color: #9ca3af;
            margin-top: 4px;
        }

        .back-btn {
            display: block;
            text-align: center;
            margin: 1rem 1.25rem;
            padding: .75rem;
            background: #eff6ff;
            color: #1d4ed8;
            border-radius: 14px;
            font-weight: 700;
            font-size: .85rem;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="track-header">
        <h1>📦 Lacak Pesanan</h1>
        <p>#{{ $order->order_code }}</p>
    </div>

    <div id="map" class="track-map"></div>

    <div class="track-info">
        {{-- Status --}}
        <div class="info-row">
            <div class="info-icon orange">🚴</div>
            <div>
                <div class="info-label">Status</div>
                <div class="info-value">
                    <span class="status-badge">
                        <span class="pulse"></span>
                        Dalam Pengantaran
                    </span>
                </div>
            </div>
        </div>

        {{-- Kurir --}}
        <div class="info-row">
            <div class="info-icon blue">👤</div>
            <div>
                <div class="info-label">Kurir</div>
                <div class="info-value" id="courier-name">Memuat...</div>
            </div>
        </div>

        {{-- Tujuan --}}
        <div class="info-row">
            <div class="info-icon green">📍</div>
            <div>
                <div class="info-label">Tujuan</div>
                <div class="info-value">{{ $order->address->address ?? '-' }}</div>
            </div>
        </div>

        {{-- Terakhir diperbarui --}}
        <div class="info-row">
            <div class="info-icon blue">🕐</div>
            <div>
                <div class="info-label">Lokasi Diperbarui</div>
                <div class="info-value" id="updated-at">Menunggu data GPS...</div>
            </div>
        </div>
    </div>

    <a href="javascript:history.back()" class="back-btn">← Kembali ke Pesanan</a>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const ORDER_ID = '{{ $order->id }}';
        const DEST_LAT = {{ $order->address->latitude ?? 'null' }};
        const DEST_LNG = {{ $order->address->longitude ?? 'null' }};

        // ✅ Koordinat depot sebagai posisi default kurir
        const DEPOT_LAT = -6.1413375;
        const DEPOT_LNG = 106.7869347;

        const map = L.map('map').setView([DEPOT_LAT, DEPOT_LNG], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap', maxZoom: 19
        }).addTo(map);

        // Marker tujuan (rumah customer)
        if (DEST_LAT && DEST_LNG) {
            L.marker([DEST_LAT, DEST_LNG], {
                icon: L.divIcon({
                    className: '',
                    html: `<div style="background:#dc2626;color:#fff;width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:18px;box-shadow:0 2px 8px rgba(0,0,0,.3);border:2px solid #fff;">🏠</div>`,
                    iconSize: [36, 36], iconAnchor: [18, 18],
                })
            }).addTo(map).bindPopup('<b>Lokasi Kamu</b>');
        }

        // Marker depot
        L.marker([DEPOT_LAT, DEPOT_LNG], {
            icon: L.divIcon({
                className: '',
                html: `<div style="background:#1a56db;color:#fff;width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:18px;box-shadow:0 2px 8px rgba(0,0,0,.3);border:2px solid #fff;">🏪</div>`,
                iconSize: [36, 36], iconAnchor: [18, 18],
            })
        }).addTo(map).bindPopup('<b>Depot / Toko</b>');

        // ✅ Marker kurir — default di depot dulu sebelum ada data GPS
        let courierMarker = L.marker([DEPOT_LAT, DEPOT_LNG], {
            icon: L.divIcon({
                className: '',
                html: `<div style="background:#059669;color:#fff;width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:18px;box-shadow:0 2px 8px rgba(0,0,0,.3);border:3px solid #fff;">🛵</div>`,
                iconSize: [36, 36], iconAnchor: [18, 18],
            })
        }).addTo(map).bindPopup('<b>Posisi Kurir</b>');

        // Fit bounds depot + tujuan supaya keduanya kelihatan
        if (DEST_LAT && DEST_LNG) {
            map.fitBounds(
                L.latLngBounds([DEPOT_LAT, DEPOT_LNG], [DEST_LAT, DEST_LNG]),
                { padding: [50, 50] }
            );
        }

        function updateCourierMarker(lat, lng) {
            // ✅ Hanya pindahkan marker, tidak buat baru — karena sudah ada sejak awal
            courierMarker.setLatLng([lat, lng]);
        }

        function fetchTracking() {
            fetch(`/api/tracking/${ORDER_ID}`)
                .then(r => r.json())
                .then(data => {
                    if (data.courier_name) {
                        document.getElementById('courier-name').textContent = data.courier_name;
                    }

                    if (data.updated_at) {
                        document.getElementById('updated-at').textContent = data.updated_at;
                    }

                    // ✅ Hanya update posisi jika sudah ada data GPS real dari kurir
                    if (data.courier_lat && data.courier_lng) {
                        updateCourierMarker(data.courier_lat, data.courier_lng);
                        document.getElementById('updated-at').textContent = data.updated_at;
                    } else {
                        // Belum ada GPS — tampilkan info bahwa kurir masih di depot
                        document.getElementById('updated-at').textContent = 'Kurir masih di depot, belum berangkat';
                    }

                    if (data.order_status === 'completed') {
                        window.location.href = '{{ route("customer.order") }}?tab=completed';
                    }
                })
                .catch(err => console.error('Tracking error:', err));
        }

        fetchTracking();
        setInterval(fetchTracking, 5000);
    </script>
</body>

</html>