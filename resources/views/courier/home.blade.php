<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Bricolage+Grotesque:wght@500;600;700;800&display=swap');

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
            --shadow-sm: 0 1px 4px rgba(15, 23, 42, .06), 0 4px 16px rgba(15, 23, 42, .06);
            --shadow-md: 0 2px 8px rgba(15, 23, 42, .08), 0 8px 32px rgba(15, 23, 42, .08);
        }

        .courier-app {
            font-family: 'Instrument Sans', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            padding-bottom: 4rem;
            color: var(--text-1);
        }

        /* ── Header ─────────────────────────────────────────── */
        .courier-header {
            background: var(--surface);
            padding: .95rem 1.25rem 1rem;
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid var(--border);
        }

        .header-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 540px;
            margin: 0 auto;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: .8rem;
        }

        .avatar {
            width: 40px;
            height: 40px;
            background: var(--blue);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Bricolage Grotesque', sans-serif;
            font-weight: 700;
            font-size: .8rem;
            color: #fff;
            letter-spacing: .03em;
            flex-shrink: 0;
        }

        .header-name {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-weight: 700;
            font-size: .95rem;
            color: var(--text-1);
            line-height: 1.2;
        }

        .header-sub {
            font-size: .7rem;
            color: var(--text-3);
            margin-top: 1px;
        }

        .online-badge {
            display: flex;
            align-items: center;
            gap: .38rem;
            background: var(--green-lt);
            border: 1px solid #bbf7d0;
            border-radius: 999px;
            padding: .28rem .7rem;
            font-size: .68rem;
            font-weight: 600;
            color: var(--green);
        }

        .pulse-dot {
            width: 6px;
            height: 6px;
            background: #22c55e;
            border-radius: 50%;
            animation: live-pulse 2s ease-in-out infinite;
            flex-shrink: 0;
        }

        @keyframes live-pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: .5;
                transform: scale(1.5);
            }
        }

        /* ── Stats ──────────────────────────────────────────── */
        .stats-wrap {
            max-width: 540px;
            margin: 0 auto;
            padding: 1.1rem 1.25rem .25rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: .65rem;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1rem .9rem 1rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .stat-accent {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: 999px 999px 0 0;
        }

        .stat-accent.blue {
            background: var(--blue);
        }

        .stat-accent.green {
            background: var(--green);
        }

        .stat-accent.amber {
            background: var(--amber);
        }

        .stat-num {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: 2.1rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: .25rem;
        }

        .stat-num.blue {
            color: var(--blue);
        }

        .stat-num.green {
            color: var(--green);
        }

        .stat-num.amber {
            color: var(--amber);
        }

        .stat-label {
            font-size: .6rem;
            color: var(--text-3);
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        /* ── Section ────────────────────────────────────────── */
        .task-section {
            padding: 1.1rem 1.25rem .5rem;
            max-width: 540px;
            margin: 0 auto;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: .9rem;
        }

        .section-title {
            font-size: .62rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--text-3);
        }

        .task-count-pill {
            font-size: .62rem;
            font-weight: 700;
            background: var(--blue-lt);
            color: var(--blue);
            border: 1px solid var(--blue-mid);
            border-radius: 999px;
            padding: .15rem .6rem;
        }

        .task-list {
            display: flex;
            flex-direction: column;
            gap: .8rem;
        }

        /* ── Task Card ──────────────────────────────────────── */
        .task-card {
            background: var(--surface);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: box-shadow .2s, transform .15s;
        }

        .task-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-1px);
        }

        .status-strip {
            height: 3px;
        }

        .status-strip.pending {
            background: linear-gradient(90deg, #f59e0b, #fcd34d);
        }

        .status-strip.picked_up {
            background: linear-gradient(90deg, #2563eb, #60a5fa);
        }

        .status-strip.completed {
            background: linear-gradient(90deg, #16a34a, #4ade80);
        }

        .task-body {
            padding: 1rem 1.1rem .9rem;
        }

        .task-top-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: .5rem;
        }

        .task-meta {
            flex: 1;
            min-width: 0;
        }

        .task-code {
            font-size: .63rem;
            font-weight: 600;
            color: var(--text-3);
            letter-spacing: .07em;
            margin-bottom: .22rem;
        }

        .task-customer {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: .97rem;
            font-weight: 700;
            color: var(--text-1);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .task-address {
            display: flex;
            align-items: flex-start;
            gap: .3rem;
            font-size: .72rem;
            color: var(--text-2);
            margin-top: .35rem;
            line-height: 1.45;
        }

        .task-address svg {
            flex-shrink: 0;
            margin-top: 2px;
            color: var(--blue);
        }

        .badge {
            font-size: .58rem;
            font-weight: 700;
            padding: .22rem .65rem;
            border-radius: 999px;
            letter-spacing: .04em;
            text-transform: uppercase;
            flex-shrink: 0;
            white-space: nowrap;
        }

        .badge.pending {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .badge.picked_up {
            background: var(--blue-lt);
            color: #1d4ed8;
            border: 1px solid var(--blue-mid);
        }

        .badge.completed {
            background: var(--green-lt);
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .card-divider {
            height: 1px;
            background: var(--border);
            margin: 0 1.1rem;
        }

        /* ── Actions ────────────────────────────────────────── */
        .task-actions {
            display: flex;
            gap: .55rem;
            align-items: center;
            padding: .75rem 1.1rem;
        }

        .btn-main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .4rem;
            padding: .65rem 1rem;
            border-radius: 12px;
            font-size: .78rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all .18s ease;
            font-family: 'Instrument Sans', sans-serif;
            letter-spacing: .01em;
        }

        .btn-main:active {
            transform: scale(.97);
        }

        .btn-main:disabled {
            opacity: .55;
            cursor: not-allowed;
        }

        .btn-main.pickup {
            background: var(--blue);
            color: #fff;
            box-shadow: 0 2px 10px rgba(37, 99, 235, .3);
        }

        .btn-main.pickup:hover {
            background: #1d4ed8;
            box-shadow: 0 4px 16px rgba(37, 99, 235, .4);
        }

        .btn-main.show-map {
            background: #7c3aed;
            color: #fff;
            box-shadow: 0 2px 10px rgba(124, 58, 237, .28);
        }

        .btn-main.show-map:hover {
            background: #6d28d9;
            box-shadow: 0 4px 16px rgba(124, 58, 237, .4);
        }

        .btn-main.done {
            background: #f8fafc;
            color: var(--text-3);
            cursor: default;
            border: 1px solid var(--border);
            box-shadow: none;
        }

        .btn-wa {
            width: 40px;
            height: 40px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
            text-decoration: none;
            transition: all .18s;
        }

        .btn-wa:hover {
            background: #dcfce7;
            transform: scale(1.05);
        }

        .btn-wa:active {
            transform: scale(.93);
        }

        /* ── Map Panel ──────────────────────────────────────── */
        .map-panel {
            display: none;
            flex-direction: column;
        }

        .map-panel.open {
            display: flex;
        }

        .map-status-bar {
            background: var(--blue-lt);
            border-top: 1px solid var(--blue-mid);
            padding: .5rem 1.1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .5rem;
        }

        .map-status-left {
            display: flex;
            align-items: center;
            gap: .4rem;
            font-size: .7rem;
            font-weight: 600;
            color: #1d4ed8;
        }

        .gps-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--text-3);
            flex-shrink: 0;
            transition: background .3s;
        }

        .gps-dot.on {
            background: #22c55e;
            animation: live-pulse 2s infinite;
        }

        .eta-chip {
            font-size: .63rem;
            font-weight: 700;
            background: #fff;
            color: #1d4ed8;
            border: 1px solid var(--blue-mid);
            border-radius: 999px;
            padding: .18rem .65rem;
            display: none;
        }

        .eta-chip.show {
            display: inline-flex;
            align-items: center;
            gap: .3rem;
        }

        .map-container {
            height: 256px;
            width: 100%;
        }

        /* Route strip */
        .route-strip {
            display: none;
            align-items: center;
            justify-content: space-around;
            padding: .7rem 1.1rem;
            background: #fafbff;
            border-top: 1px solid var(--border);
            gap: .5rem;
        }

        .route-strip.show {
            display: flex;
        }

        .route-item {
            text-align: center;
            flex: 1;
        }

        .route-val {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: .9rem;
            font-weight: 700;
            color: var(--text-1);
        }

        .route-lbl {
            font-size: .58rem;
            color: var(--text-3);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-top: 2px;
        }

        .route-sep {
            width: 1px;
            height: 28px;
            background: var(--border);
        }

        /* Confirm bar */
        .confirm-bar {
            padding: .85rem 1.1rem;
            background: var(--green-lt);
            border-top: 1px solid #bbf7d0;
            display: flex;
            flex-direction: column;
            gap: .5rem;
        }

        .confirm-hint {
            font-size: .68rem;
            font-weight: 600;
            color: var(--green);
            display: flex;
            align-items: center;
            gap: .35rem;
        }

        .btn-confirm {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .45rem;
            padding: .78rem 1rem;
            background: var(--green);
            color: #fff;
            font-size: .82rem;
            font-weight: 700;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-family: 'Instrument Sans', sans-serif;
            box-shadow: 0 2px 12px rgba(22, 163, 74, .28);
            transition: all .18s;
        }

        .btn-confirm:hover {
            background: #15803d;
            box-shadow: 0 4px 18px rgba(22, 163, 74, .38);
        }

        .btn-confirm:active {
            transform: scale(.98);
        }

        .btn-confirm:disabled {
            opacity: .55;
            cursor: not-allowed;
        }

        /* ── Empty ──────────────────────────────────────────── */
        .empty-state {
            text-align: center;
            padding: 3.5rem 1rem;
            background: var(--surface);
            border: 1.5px dashed var(--border);
            border-radius: var(--radius);
        }

        .empty-icon {
            width: 60px;
            height: 60px;
            background: var(--blue-lt);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.6rem;
        }

        .empty-title {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: .95rem;
            font-weight: 700;
            color: var(--text-1);
            margin-bottom: .3rem;
        }

        .empty-sub {
            font-size: .78rem;
            color: var(--text-3);
        }

        /* ── Toast ──────────────────────────────────────────── */
        .toast-wrap {
            position: fixed;
            bottom: 1.5rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: .45rem;
            align-items: center;
            pointer-events: none;
            width: min(400px, 92vw);
        }

        .toast {
            width: 100%;
            padding: .65rem 1.1rem;
            border-radius: 12px;
            font-size: .78rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: .5rem;
            box-shadow: 0 4px 20px rgba(15, 23, 42, .15);
            opacity: 0;
            transform: translateY(8px) scale(.97);
            transition: all .28s cubic-bezier(.34, 1.56, .64, 1);
            pointer-events: none;
            font-family: 'Instrument Sans', sans-serif;
            border: 1px solid transparent;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .toast.success {
            background: #f0fdf4;
            color: #15803d;
            border-color: #bbf7d0;
        }

        .toast.error {
            background: #fef2f2;
            color: #dc2626;
            border-color: #fecaca;
        }

        .toast.info {
            background: var(--blue-lt);
            color: #1d4ed8;
            border-color: var(--blue-mid);
        }

        /* ── Leaflet overrides ──────────────────────────────── */
        .leaflet-control-zoom a {
            background: var(--surface) !important;
            color: var(--text-1) !important;
            border-color: var(--border) !important;
            font-size: 14px !important;
        }

        .leaflet-control-zoom a:hover {
            background: var(--bg) !important;
        }

        .leaflet-popup-content-wrapper {
            border-radius: 12px !important;
            box-shadow: var(--shadow-md) !important;
            border: 1px solid var(--border) !important;
        }

        .leaflet-popup-content {
            font-family: 'Instrument Sans', sans-serif;
            font-size: .82rem;
        }

        .leaflet-control-attribution {
            font-size: .58rem !important;
            background: rgba(255, 255, 255, .85) !important;
        }

        .delivery-popup {
            width: 500px;
            border-radius: 24px;
            padding: 24px;
        }
        
        .delivery-icon {
            width: 90px;
            height: 90px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: #dcfce7;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .delivery-icon i {
            font-size: 36px;
            color: #22c55e;
        }
        
        .delivery-text {
            margin-top: 10px;
            color: #64748b;
            line-height: 1.6;
        }
        
        .delivery-confirm {
            width: 100%;
            height: 52px;
            border: none;
            border-radius: 14px;
            background: #22c55e;
            color: white;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .delivery-confirm:hover {
            background: #16a34a;
        }
        
        .delivery-cancel {
            width: 100%;
            height: 52px;
            border: none;
            border-radius: 14px;
            background: #f1f5f9;
            color: #475569;
            font-weight: 600;
        }

        /* ── Bottom Sheet Confirm ────────────────────────────── */
.ef-sheet-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, .45);
    z-index: 9998;
    align-items: flex-end;
    justify-content: center;
}

.ef-sheet-overlay.open {
    display: flex;
}

.ef-sheet {
    background: var(--surface);
    border-radius: 24px 24px 0 0;
    width: 100%;
    max-width: 540px;
    padding: 1.25rem 1.5rem 2rem;
    animation: efSheetUp .28s cubic-bezier(.34, 1.3, .64, 1) forwards;
}

@keyframes efSheetUp {
    from { transform: translateY(60px); opacity: 0; }
    to   { transform: translateY(0);    opacity: 1; }
}

.ef-sheet__pill {
    width: 36px;
    height: 4px;
    background: var(--border);
    border-radius: 999px;
    margin: 0 auto .9rem;
}

.ef-sheet__icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    background: var(--green-lt);
    border: 1px solid #bbf7d0;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto .9rem;
    color: var(--green);
}

.ef-sheet__title {
    font-family: 'Bricolage Grotesque', sans-serif;
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--text-1);
    text-align: center;
    margin-bottom: .4rem;
}

.ef-sheet__body {
    font-size: .8rem;
    color: var(--text-2);
    text-align: center;
    line-height: 1.55;
    margin-bottom: 1.25rem;
}

.ef-sheet__actions {
    display: flex;
    flex-direction: column;
    gap: .55rem;
}

.ef-sheet__btn-confirm {
    width: 100%;
    padding: .82rem 1rem;
    background: var(--green);
    color: #fff;
    font-size: .85rem;
    font-weight: 700;
    border: none;
    border-radius: 14px;
    cursor: pointer;
    font-family: 'Instrument Sans', sans-serif;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .45rem;
    box-shadow: 0 2px 12px rgba(22, 163, 74, .28);
    transition: all .18s;
}

.ef-sheet__btn-confirm:hover  { background: #15803d; }
.ef-sheet__btn-confirm:active { transform: scale(.98); }

.ef-sheet__btn-cancel {
    width: 100%;
    padding: .78rem 1rem;
    background: var(--bg);
    color: var(--text-2);
    font-size: .82rem;
    font-weight: 600;
    border: 1px solid var(--border);
    border-radius: 14px;
    cursor: pointer;
    font-family: 'Instrument Sans', sans-serif;
    transition: all .18s;
}

.ef-sheet__btn-cancel:hover { background: var(--border); }
    </style>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <main class="courier-app">

        {{-- Header --}}
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
                    Online
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="stats-wrap">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-accent blue"></div>
                    <div class="stat-num blue">{{ $todayTasks ?? 0 }}</div>
                    <div class="stat-label">Total</div>
                </div>
                <div class="stat-card">
                    <div class="stat-accent green"></div>
                    <div class="stat-num green">{{ $completedToday ?? 0 }}</div>
                    <div class="stat-label">Selesai</div>
                </div>
                <div class="stat-card">
                    <div class="stat-accent amber"></div>
                    <div class="stat-num amber">{{ $pendingToday ?? 0 }}</div>
                    <div class="stat-label">Antrian</div>
                </div>
            </div>
        </div>

        {{-- Task list --}}
        <div class="task-section">
            <div class="section-header">
                <span class="section-title">Tugas Hari Ini</span>
                @if ($tasks->count() > 0)
                    <span class="task-count-pill">{{ $tasks->count() }} aktif</span>
                @endif
            </div>

            <div class="task-list">
                @forelse($tasks as $task)
                    @php
                        $destLat = $task->order->address->latitude ?? null;
                        $destLng = $task->order->address->longitude ?? null;
                        $phone = $task->order->user->phone ?? '';
                        $cleanPhone = preg_replace('/\D/', '', $phone);
                        $isValidWa = preg_match('/^(08|628|8)\d{8,11}$/', $cleanPhone);
                        $wa = '62' . ltrim($cleanPhone, '08');
                        $chatUrl = route('courier.chat.show', $task->order->user->id) . '?order_id=' . $task->order->id;
                        $customerId = $task->order->user->id;                            // ← dan ini
                        $unreadFromCustomer = \App\Models\Chat::where('sender_id', $task->order->user->id)
                            ->where('receiver_id', auth()->id())
                            ->where('order_id', $task->order->id)  // ← filter by order
                            ->whereNull('read_at')
                            ->count();
                    @endphp
                    
                    @php
                        if (str_starts_with($cleanPhone, '62')) {
                            $wa = $cleanPhone;
                        } elseif (str_starts_with($cleanPhone, '0')) {
                            $wa = '62' . substr($cleanPhone, 1);
                        } elseif (str_starts_with($cleanPhone, '8')) {
                            $wa = '62' . $cleanPhone;
                        } else {
                            // Nomor seperti 1239013436 → tambah 628 di depan
                            $wa = '628' . $cleanPhone;
                        }

                        $isValidWa = strlen($wa) >= 11 && strlen($wa) <= 15 && str_starts_with($wa, '62');
                    @endphp
                    <div class="task-card" id="card-{{ $task->id }}">
                        <div class="status-strip {{ $task->status }}"></div>

                        <div class="task-body">
                            <div class="task-top-row">
                                <div class="task-meta">
                                    <div class="task-code">{{ $task->order->order_code ?? '-' }}</div>
                                    <div class="task-customer">{{ $task->order->user->name ?? '-' }}</div>
                                    <div class="task-address">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ Str::limit($task->order->address->address ?? '-', 52) }}
                                    </div>
                                </div>
                                <span class="badge {{ $task->status }}">
                                    @if ($task->status === 'pending')
                                        Menunggu
                                    @elseif($task->status === 'picked_up')
                                        Diantar
                                    @else
                                        Selesai
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="card-divider"></div>

                        <div class="task-actions">
                            @if ($task->status === 'pending')
                                <button onclick="pickupTask({{ $task->id }}, this)" class="btn-main pickup">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    Ambil Barang
                                </button>
                            @elseif($task->status === 'picked_up')
                                <button
                                    onclick="openDeliveryMap({{ $task->id }}, {{ $destLat ?? 'null' }}, {{ $destLng ?? 'null' }})"
                                    class="btn-main show-map" id="btn-start-{{ $task->id }}">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                    </svg>
                                    Mulai Antar
                                </button>
                            @else
                                <button class="btn-main done" disabled>
                                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Terkirim
                                </button>
                            @endif

                            @php
                                $phone = $task->order->user->phone ?? '';
                                $cleanPhone = preg_replace('/\D/', '', $phone);
                                $isValidWa = preg_match('/^(08|628|8)\d{8,11}$/', $cleanPhone);
                                $wa = '62' . ltrim($cleanPhone, '08');
                            @endphp

                            @if ($isValidWa)
                                <a href="https://wa.me/{{ $wa }}" target="_blank" class="btn-wa"
                                    aria-label="Hubungi via WhatsApp">
                                    <svg width="17" height="17" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                    </svg>
                                </a>

                            @else
                                <div class="btn-wa" style="cursor:default;opacity:.5;" title="Nomor tidak valid">
                                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </div>
                            @endif

                            {{-- In-app chat: selalu tampil --}}
                            <a href="{{ $chatUrl }}" class="btn-wa"
                                style="background:#eff6ff;color:#2563eb;border-color:#dbeafe;position:relative;"
                                aria-label="Chat in-app">
                                <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                                </svg>
                                {{-- ID unik per customer untuk di-update JS --}}
                                <span id="chat-badge-task-{{ $task->order->id }}" style="display:none;position:absolute;top:-5px;right:-5px;
                                     background:#ef4444;color:#fff;font-size:.55rem;font-weight:700;
                                     min-width:16px;height:16px;border-radius:999px;
                                     align-items:center;justify-content:center;
                                     padding:0 3px;border:2px solid #fff;line-height:1;">
                                </span>
                            </a>
                        </div>

                        {{-- Map panel — only picked_up --}}
                        @if ($task->status === 'picked_up')
                            <div class="map-panel" id="map-panel-{{ $task->id }}">

                                <div class="map-status-bar">
                                    <div class="map-status-left">
                                        <div class="gps-dot" id="gps-dot-{{ $task->id }}"></div>
                                        <span id="gps-label-{{ $task->id }}">Mengaktifkan GPS…</span>
                                    </div>
                                    <span class="eta-chip" id="eta-chip-{{ $task->id }}">
                                        🕐 <span id="eta-val-{{ $task->id }}">–</span>
                                    </span>
                                </div>

                                <div class="map-container" id="map-{{ $task->id }}"></div>

                                <div class="route-strip" id="route-strip-{{ $task->id }}">
                                    <div class="route-item">
                                        <div class="route-val" id="r-dist-{{ $task->id }}">–</div>
                                        <div class="route-lbl">Jarak</div>
                                    </div>
                                    <div class="route-sep"></div>
                                    <div class="route-item">
                                        <div class="route-val" id="r-eta-{{ $task->id }}">–</div>
                                        <div class="route-lbl">Estimasi</div>
                                    </div>
                                    <div class="route-sep"></div>
                                    <div class="route-item">
                                        <div class="route-val" id="r-speed-{{ $task->id }}">– km/h</div>
                                        <div class="route-lbl">Kecepatan</div>
                                    </div>
                                </div>

                                <div class="confirm-bar">
                                    <div class="confirm-hint">
                                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Tekan setelah barang diserahkan ke customer
                                    </div>
                                    <button onclick="deliverTask({{ $task->id }}, this)" class="btn-confirm"
                                        id="btn-deliver-{{ $task->id }}">
                                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Konfirmasi Sudah Terkirim
                                    </button>
                                </div>
                            </div>
                        @endif

                    </div>
                @empty
                    <div class="empty-state">
                        <div class="empty-icon">📭</div>
                        <div class="empty-title">Tidak ada tugas hari ini</div>
                        <div class="empty-sub">Santai dulu, pesanan belum masuk 😊</div>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="toast-wrap" id="toastWrap"></div>

        {{-- Bottom Sheet — Konfirmasi Terkirim --}}
<div class="ef-sheet-overlay" id="deliverSheet">
    <div class="ef-sheet" id="deliverSheetBox">
        <div class="ef-sheet__pill"></div>
        <div class="ef-sheet__icon">
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h3 class="ef-sheet__title">Pesanan Sudah Diterima?</h3>
        <p class="ef-sheet__body">
            Pastikan pesanan telah diterima oleh customer.<br>
            Status pesanan akan diubah menjadi <strong>Selesai</strong>.
        </p>
        <div class="ef-sheet__actions">
            <button class="ef-sheet__btn-confirm" id="deliverSheetConfirm">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Ya, Pesanan Diterima
            </button>
            <button class="ef-sheet__btn-cancel" id="deliverSheetCancel">Batal</button>
        </div>
    </div>
</div>
    </main>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
       let hiddenAt = null;

        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'hidden') {
                hiddenAt = Date.now();
            } else if (document.visibilityState === 'visible') {
                // Reload kalau sudah lebih dari 3 detik meninggalkan halaman
                if (hiddenAt && Date.now() - hiddenAt > 3000) {
                    window.location.reload();
                }
            }
        });

        /* ═══════════════════════════════════════════════
                                       COURIER — Production JS
                                    ═══════════════════════════════════════════════ */
        const DEPOT_LAT = -6.1413375;
        const DEPOT_LNG = 106.7869347;
        const CSRF = document.querySelector('meta[name="csrf-token"]').content;

        const maps = {}; // taskId → L.Map
        const markers = {}; // taskId → L.Marker (kurir)
        const routes = {}; // taskId → L.Polyline[]
        const gpsTimers = {}; // taskId → intervalId
        const osrmTimer = {}; // taskId → last fetch timestamp

        /* ── Toast ─────────────────────────────────── */
        function toast(msg, type = 'info') {
            const wrap = document.getElementById('toastWrap');
            const el = document.createElement('div');
            el.className = `toast ${type}`;
            el.innerHTML = msg;
            wrap.appendChild(el);
            requestAnimationFrame(() => requestAnimationFrame(() => el.classList.add('show')));
            setTimeout(() => {
                el.classList.remove('show');
                setTimeout(() => el.remove(), 320);
            }, 3200);
        }

        /* ── Pickup ────────────────────────────────── */
        function pickupTask(id, btn) {
            btn.disabled = true;
            btn.innerHTML = '⏳ Memproses…';

            fetch(`/courier/tasks/${id}/pickup`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json'
                }
            })
                .then(r => r.json())
                .then(d => {
                    if (d.success) {
                        toast('✓ Barang berhasil diambil! Siap antar ke customer.', 'success');
                        setTimeout(() => location.reload(), 900);
                    } else {
                        toast('Gagal: ' + (d.message ?? 'Coba lagi'), 'error');
                        btn.disabled = false;
                        btn.innerHTML = 'Ambil Barang';
                    }
                })
                .catch(() => {
                    toast('Terjadi kesalahan koneksi', 'error');
                    btn.disabled = false;
                    btn.innerHTML = 'Ambil Barang';
                });
        }

        /* ── Open map ──────────────────────────────── */
        function openDeliveryMap(id, dLat, dLng) {
            if (!dLat || !dLng) {
                toast('⚠️ Alamat customer belum punya koordinat GPS', 'error');
                return;
            }
            const btn = document.getElementById('btn-start-' + id);
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '⏳ Memulai…';
            }

            fetch(`/courier/tasks/${id}/start-delivery`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json'
                }
            })
                .then(r => r.json())
                .then(d => {
                    if (!d.success) {
                        toast('Gagal memulai: ' + (d.message ?? ''), 'error');
                        if (btn) {
                            btn.disabled = false;
                            btn.innerHTML = 'Mulai Antar';
                        }
                        return;
                    }
                    const panel = document.getElementById('map-panel-' + id);
                    panel.classList.add('open');
                    if (btn) btn.style.display = 'none';
                    if (!maps[id]) initMap(id, dLat, dLng);
                    setTimeout(() => panel.scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest'
                    }), 180);
                    toast('📍 GPS aktif — navigasi ke tujuan', 'info');
                })
                .catch(() => {
                    toast('Kesalahan koneksi', 'error');
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = 'Mulai Antar';
                    }
                });
        }

        /* ── Init Leaflet ──────────────────────────── */
        function initMap(id, dLat, dLng) {
            const map = L.map('map-' + id, {
                zoomControl: true
            })
                .setView([DEPOT_LAT, DEPOT_LNG], 13);
            maps[id] = map;

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19,
            }).addTo(map);

            // Depot
            L.marker([DEPOT_LAT, DEPOT_LNG], {
                icon: mkIcon('🏪', '#2563eb')
            })
                .addTo(map).bindPopup('<b>Depot / Toko</b>');

            // Tujuan
            L.marker([dLat, dLng], {
                icon: mkIcon('📦', '#dc2626')
            })
                .addTo(map).bindPopup('<b>Tujuan Customer</b>');

            // Kurir — mulai di depot
            markers[id] = L.marker([DEPOT_LAT, DEPOT_LNG], {
                icon: mkIcon('🛵', '#16a34a', true),
                zIndexOffset: 1000
            }).addTo(map).bindPopup('<b>Posisi Anda</b>');

            map.fitBounds(
                L.latLngBounds([DEPOT_LAT, DEPOT_LNG], [dLat, dLng]), {
                padding: [52, 52]
            }
            );

            // Rute awal depot → tujuan
            fetchRoute(id, DEPOT_LAT, DEPOT_LNG, dLat, dLng);

            // GPS
            startGps(id, dLat, dLng);
        }

        /* ── Icon helper ───────────────────────────── */
        function mkIcon(emoji, color, large = false) {
            const s = large ? 42 : 36;
            return L.divIcon({
                className: '',
                html: `<div style="background:${color};width:${s}px;height:${s}px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:${large ? 20 : 16}px;box-shadow:0 2px 10px rgba(0,0,0,.25);border:2.5px solid #fff;">${emoji}</div>`,
                iconSize: [s, s],
                iconAnchor: [s / 2, s / 2],
            });
        }

        /* ── OSRM route (throttled 8s) ─────────────── */
        function fetchRoute(id, fLat, fLng, tLat, tLng) {
            const now = Date.now();
            if (osrmTimer[id] && now - osrmTimer[id] < 8000) return;
            osrmTimer[id] = now;

            fetch(
                `https://router.project-osrm.org/route/v1/driving/${fLng},${fLat};${tLng},${tLat}?overview=full&geometries=geojson`
            )
                .then(r => r.json())
                .then(data => {
                    if (!data.routes?.length) return;
                    const route = data.routes[0];
                    const coords = route.geometry.coordinates.map(c => [c[1], c[0]]);
                    const distKm = (route.distance / 1000).toFixed(1);
                    const etaMins = Math.ceil(route.duration / 60);

                    const map = maps[id];
                    if (!map) return;

                    // Hapus rute lama
                    (routes[id] || []).forEach(l => map.removeLayer(l));

                    // Glow + solid line
                    const glow = L.polyline(coords, {
                        color: 'rgba(37,99,235,.18)',
                        weight: 9,
                        lineCap: 'round',
                        lineJoin: 'round',
                    }).addTo(map);

                    const line = L.polyline(coords, {
                        color: '#2563eb',
                        weight: 4,
                        opacity: .85,
                        lineCap: 'round',
                        lineJoin: 'round',
                    }).addTo(map);

                    routes[id] = [glow, line];

                    // Update strip
                    const strip = document.getElementById('route-strip-' + id);
                    if (strip) {
                        strip.classList.add('show');
                        document.getElementById('r-dist-' + id).textContent = distKm + ' km';
                        document.getElementById('r-eta-' + id).textContent = etaMins + ' mnt';
                    }

                    // Update ETA chip
                    const chip = document.getElementById('eta-chip-' + id);
                    const val = document.getElementById('eta-val-' + id);
                    if (chip && val) {
                        chip.classList.add('show');
                        val.textContent = etaMins + ' mnt';
                    }
                })
                .catch(() => {
                    // Fallback: garis lurus
                    const map = maps[id];
                    if (!map) return;
                    (routes[id] || []).forEach(l => map.removeLayer(l));
                    const fb = L.polyline([
                        [fLat, fLng],
                        [tLat, tLng]
                    ], {
                        color: '#2563eb',
                        weight: 3,
                        opacity: .55,
                        dashArray: '7, 5'
                    }).addTo(map);
                    routes[id] = [fb];
                });
        }

        /* ── GPS tracking ──────────────────────────── */
        function startGps(id, dLat, dLng) {
            if (!navigator.geolocation) {
                document.getElementById('gps-label-' + id).textContent = 'GPS tidak tersedia';
                return;
            }
            const dot = document.getElementById('gps-dot-' + id);
            const label = document.getElementById('gps-label-' + id);

            function send() {
                navigator.geolocation.getCurrentPosition(pos => {
                    const {
                        latitude: lat,
                        longitude: lng,
                        speed: spd
                    } = pos.coords;

                    // Geser marker kurir
                    if (markers[id]) markers[id].setLatLng([lat, lng]);

                    // Update rute dari posisi kurir → tujuan (throttled)
                    fetchRoute(id, lat, lng, dLat, dLng);

                    // Kecepatan
                    const speedEl = document.getElementById('r-speed-' + id);
                    if (speedEl) speedEl.textContent = (spd != null ? Math.round(spd * 3.6) : 0) + ' km/h';

                    // Kirim ke server
                    fetch(`/courier/tasks/${id}/location`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': CSRF,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            latitude: lat,
                            longitude: lng,
                            speed: spd
                        }),
                    })
                        .then(r => r.json())
                        .then(d => {
                            if (d.success) {
                                dot.classList.add('on');
                                label.textContent = 'GPS aktif · ' + new Date().toLocaleTimeString('id-ID');
                            }
                        })
                        .catch(() => {
                            dot.classList.remove('on');
                            label.textContent = 'Gagal kirim lokasi, mencoba ulang…';
                        });

                }, err => {
                    dot.classList.remove('on');
                    label.textContent = 'GPS error: ' + err.message;
                }, {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                });
            }

            send();
            gpsTimers[id] = setInterval(send, 5000);
        }

        /* ── Deliver ───────────────────────────────── */
        /* ── Deliver ───────────────────────────────── */
        function deliverTask(id, btn) {
    const sheet = document.getElementById('deliverSheet');
    const sheetBox = document.getElementById('deliverSheetBox');
    const confirmBtn = document.getElementById('deliverSheetConfirm');
    const cancelBtn = document.getElementById('deliverSheetCancel');

    sheet.classList.add('open');

    function closeSheet() {
        sheetBox.style.animation = 'efSheetDown .22s cubic-bezier(.4,0,1,1) forwards';
        if (!document.getElementById('efSheetDownKf')) {
            const s = document.createElement('style');
            s.id = 'efSheetDownKf';
            s.textContent = '@keyframes efSheetDown{to{transform:translateY(60px);opacity:0}}';
            document.head.appendChild(s);
        }
        setTimeout(() => {
            sheet.classList.remove('open');
            sheetBox.style.animation = '';
        }, 220);
    }

    function cleanup() {
        confirmBtn.removeEventListener('click', handleConfirm);
        cancelBtn.removeEventListener('click', handleCancel);
        sheet.removeEventListener('click', handleBackdrop);
        document.removeEventListener('keydown', handleEsc);
    }

    function handleConfirm() {
        cleanup();
        closeSheet();

        btn.disabled = true;
        btn.innerHTML = '⏳ Memproses…';

        fetch(`/courier/tasks/${id}/deliver`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(d => {
            if (d.success) {
                if (gpsTimers[id]) { clearInterval(gpsTimers[id]); delete gpsTimers[id]; }
                toast('🎉 Pesanan berhasil diantarkan!', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                toast('Gagal: ' + (d.message ?? 'Coba lagi'), 'error');
                btn.disabled = false;
                btn.innerHTML = 'Konfirmasi Sudah Terkirim';
            }
        })
        .catch(() => {
            toast('Kesalahan koneksi', 'error');
            btn.disabled = false;
            btn.innerHTML = 'Konfirmasi Sudah Terkirim';
        });
    }

    function handleCancel()  { cleanup(); closeSheet(); }
    function handleBackdrop(e) { if (e.target === sheet) { cleanup(); closeSheet(); } }
    function handleEsc(e)    { if (e.key === 'Escape') { cleanup(); closeSheet(); } }

    confirmBtn.addEventListener('click', handleConfirm);
    cancelBtn.addEventListener('click', handleCancel);
    sheet.addEventListener('click', handleBackdrop);
    document.addEventListener('keydown', handleEsc);
}
        // function deliverTask(id, btn) {
        //     if (!confirm('Konfirmasi: barang sudah diserahkan ke customer?')) return;
        //     btn.disabled = true;
        //     btn.innerHTML = '⏳ Memproses…';

        //     fetch(`/courier/tasks/${id}/deliver`, {
        //         method: 'POST',
        //         headers: {
        //             'X-CSRF-TOKEN': CSRF,
        //             'Accept': 'application/json'
        //         }
        //     })
        //         .then(r => r.json())
        //         .then(d => {
        //             if (d.success) {
        //                 if (gpsTimers[id]) {
        //                     clearInterval(gpsTimers[id]);
        //                     delete gpsTimers[id];
        //                 }
        //                 toast('🎉 Pesanan berhasil diantarkan!', 'success');
        //                 setTimeout(() => location.reload(), 1000);
        //             } else {
        //                 toast('Gagal: ' + (d.message ?? 'Coba lagi'), 'error');
        //                 btn.disabled = false;
        //                 btn.innerHTML = 'Konfirmasi Sudah Terkirim';
        //             }
        //         })
        //         .catch(() => {
        //             toast('Kesalahan koneksi', 'error');
        //             btn.disabled = false;
        //             btn.innerHTML = 'Konfirmasi Sudah Terkirim';
        //         });
        // }

        (function () {
            const authId = @json(auth()->id());

            function waitForEcho(cb) {
                let attempts = 0;
                const interval = setInterval(() => {
                    attempts++;

                    if (window.Echo) {
                        clearInterval(interval);
                        cb();
                    }

                    if (attempts > 50) {
                        clearInterval(interval);
                    }
                }, 100);
            }

            const unreadMap = {};

            @foreach($tasks as $task)
                @php
                    $unreadCount = \App\Models\Chat::where('sender_id', $task->order->user->id)
                        ->where('receiver_id', auth()->id())
                        ->where('order_id', $task->order->id)
                        ->whereNull('read_at')
                        ->count();
                @endphp

                unreadMap['{{ $task->order->id }}'] = {{ $unreadCount }};
            @endforeach

            function renderBadge(orderId, count) {
                const badge = document.getElementById('chat-badge-task-' + orderId);

                if (!badge) return;

                badge.textContent = count > 9 ? '9+' : count;
                badge.style.display = count > 0 ? 'inline-flex' : 'none';
            }

            Object.entries(unreadMap).forEach(([orderId, count]) => {
                renderBadge(orderId, count);
            });

        waitForEcho(() => {

            window.Echo
                .private('user.{{ auth()->id() }}')
                .listen('.chat.sent', (e) => {

                    console.log('CHAT MASUK', e);

                    if (String(e.chat.sender_id) === String(authId)) {
                        return;
                    }

                    const orderId = String(e.chat.order_id);

                    unreadMap[orderId] = (unreadMap[orderId] || 0) + 1;

                    renderBadge(orderId, unreadMap[orderId]);

                    toast(
                        `💬 Pesan baru dari ${e.chat.sender?.name ?? 'Customer'}`,
                        'info'
                    );
                });

        });
        })();

        // Real-time polling setiap 10 detik
        // setInterval(() => {
        //     fetch('/courier/tasks/poll', {
        //             headers: {
        //                 'Accept': 'application/json',
        //                 'X-CSRF-TOKEN': CSRF
        //             }
        //         })
        //         .then(r => r.json())
        //         .then(data => {
        //             // Update stats
        //             document.querySelector('.stat-num.blue').textContent = data.todayTasks;
        //             document.querySelector('.stat-num.green').textContent = data.completedToday;
        //             document.querySelector('.stat-num.amber').textContent = data.pendingToday;

        //             // Kalau jumlah task berubah, reload halaman
        //             const currentCount = document.querySelectorAll('.task-card').length;
        //             if (data.taskCount !== currentCount) {
        //                 location.reload();
        //             }
        //         })
        //         .catch(() => {});
        // }, 10000);
        // ── State cache task ──
        let taskCache = {}; // taskId → task data

        // Inisialisasi cache dari task yang sudah ada di DOM
        document.querySelectorAll('.task-card').forEach(card => {
            const id = card.id.replace('card-', '');
            taskCache[id] = {
                id,
                rendered: true
            };
        });

        function renderNewTaskCard(task) {
            // Buat kartu baru untuk task yang belum ada di DOM
            const div = document.createElement('div');
            div.className = 'task-card';
            div.id = 'card-' + task.id;

            const waPhone = task.phone ? (() => {
                const clean = task.phone.replace(/\D/g, '');
                if (clean.startsWith('62')) return clean;
                if (clean.startsWith('0')) return '62' + clean.slice(1);
                if (clean.startsWith('8')) return '62' + clean;
                return clean;
            })() : '';
            const isValidWa = waPhone.length >= 11 && waPhone.length <= 15 && waPhone.startsWith('62');

            div.innerHTML = `
        <div class="status-strip ${task.status}"></div>
        <div class="task-body">
            <div class="task-top-row">
                <div class="task-meta">
                    <div class="task-code">${task.order_code ?? '-'}</div>
                    <div class="task-customer">${task.customer_name ?? '-'}</div>
                    <div class="task-address">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        ${task.address ?? '-'}
                    </div>
                </div>
                <span class="badge ${task.status}">
                    ${ task.status === 'pending' ? 'Menunggu' : task.status === 'picked_up' ? 'Diantar' : 'Selesai' }
                </span>
            </div>
        </div>
        <div class="card-divider"></div>
        <div class="task-actions">
            <button onclick="pickupTask(${task.id}, this)" class="btn-main pickup">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                Ambil Barang
            </button>
            ${isValidWa
                ? `<a href="https://wa.me/${waPhone}" target="_blank" class="btn-wa" aria-label="WhatsApp">
                                <svg width="17" height="17" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                               </a>`
                : `<div class="btn-wa" style="cursor:default;opacity:.5;">
                                <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                               </div>`
            }
        </div>
    `;
            return div;
        }

        // ── Polling tanpa reload ──
        setInterval(() => {
            fetch('/courier/tasks/poll', {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF
                }
            })
                .then(r => r.json())
                .then(data => {
                    // Update stats
                    document.querySelector('.stat-num.blue').textContent = data.todayTasks;
                    document.querySelector('.stat-num.green').textContent = data.completedToday;
                    document.querySelector('.stat-num.amber').textContent = data.pendingToday;

                    const taskList = document.querySelector('.task-list');
                    const newIds = (data.tasks ?? []).map(t => String(t.id));
                    const oldIds = Object.keys(taskCache);

                    // Task baru yang belum ada di DOM → tambahkan tanpa reload
                    (data.tasks ?? []).forEach(task => {
                        const sid = String(task.id);
                        if (!taskCache[sid]) {
                            taskCache[sid] = task;

                            // Hapus empty state kalau ada
                            const empty = taskList.querySelector('.empty-state');
                            if (empty) empty.remove();

                            const card = renderNewTaskCard(task);
                            taskList.prepend(card); // taruh di atas
                            toast('📦 Pesanan baru masuk!', 'info');
                        }
                    });

                    // Task yang sudah tidak ada di response (selesai/hilang) → hapus dari cache
                    // tapi JANGAN hapus dari DOM kalau lagi dalam pengiriman (picked_up)
                    oldIds.forEach(sid => {
                        if (!newIds.includes(sid)) {
                            const card = document.getElementById('card-' + sid);
                            const isActive = card && card.querySelector('.map-panel.open');
                            if (!isActive) {
                                delete taskCache[sid];
                                // Card sudah handled oleh reload setelah deliver/pickup
                            }
                        }
                    });

                    // Kalau task list kosong
                    if (newIds.length === 0 && taskList.querySelectorAll('.task-card').length === 0) {	
                        if (!taskList.querySelector('.empty-state')) {
                            taskList.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-icon">📭</div>
                        <div class="empty-title">Tidak ada tugas hari ini</div>
                        <div class="empty-sub">Santai dulu, pesanan belum masuk 😊</div>
                    </div>`;
                        }
                    }
                })
                .catch(() => { });
        }, 10000);
    </script>
</x-app-layout>