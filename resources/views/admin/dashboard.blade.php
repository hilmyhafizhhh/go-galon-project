@extends('layout')

@section('page-title', 'Dashboard')

@section('content')

    {{-- STATISTIK CARDS --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon stat-icon--blue">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                    <rect x="9" y="3" width="6" height="4" rx="1" />
                </svg>
            </div>
            <div>
                <p class="stat-label">Total Pesanan Hari Ini</p>
                <h2 id="totalOrders" class="stat-value" style="color:#3b82f6">0</h2>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon--green">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <line x1="12" y1="1" x2="12" y2="23" />
                    <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" />
                </svg>
            </div>
            <div>
                <p class="stat-label">Pendapatan Hari Ini</p>
                <h2 id="todayIncome" class="stat-value" style="color:#22c55e">Rp 0</h2>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon--orange">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                </svg>
            </div>
            <div>
                <p class="stat-label">Pesanan Aktif Hari Ini</p>
                <h2 id="activeOrders" class="stat-value" style="color:#f97316">0</h2>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon--purple">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <circle cx="12" cy="8" r="4" />
                    <path d="M20 21a8 8 0 10-16 0" />
                </svg>
            </div>
            <div>
                <p class="stat-label">Kurir Online</p>
                <h2 id="courierOnline" class="stat-value" style="color:#a855f7">0/0</h2>
            </div>
        </div>
    </div>

    {{-- TABEL PESANAN --}}
    <div class="card mb-6">
        <div class="card-header">
            <h2 class="card-title">Daftar Pesanan Hari Ini</h2>
            <div class="filter-wrap">
                <button onclick="filterStatus('all')" id="filter-all" class="filter-btn active-filter">Semua</button>
                <button onclick="filterStatus('pending')" id="filter-pending" class="filter-btn">Menunggu</button>
                <button onclick="filterStatus('confirmed')" id="filter-confirmed" class="filter-btn">Dikonfirmasi</button>
                <button onclick="filterStatus('on_delivery')" id="filter-on_delivery" class="filter-btn">Dikirim</button>
                <button onclick="filterStatus('completed')" id="filter-completed" class="filter-btn">Selesai</button>
                <button onclick="filterStatus('cancelled')" id="filter-cancelled" class="filter-btn">Dibatalkan</button>
            </div>
        </div>
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Item</th>
                        <th>Waktu Pesan</th>
                        <th>No. Antrean</th>
                        <th>Status</th>
                        <th>Kurir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="orderTable"></tbody>
            </table>
        </div>
    </div>

    {{-- BOTTOM GRID --}}
    <div class="bottom-grid">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Kurir Aktif</h2>
            </div>
            <div id="courierList" class="list-items"></div>
        </div>
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Inventory Galon</h2>
            </div>
            <div id="inventoryList" class="list-items"></div>
        </div>
    </div>

    {{-- MODAL VALIDASI PESANAN --}}
    <div id="modalValidasi" class="modal-backdrop hidden">
        <div class="modal-box">
            <div class="modal-header">
                <h3 class="modal-title">Validasi Pesanan</h3>
                <button onclick="tutupModal()" class="modal-close">&times;</button>
            </div>
            <div class="modal-info-grid">
                <div class="modal-info-row"><span class="modal-info-label">ID Pesanan</span><span id="modalOrderCode"
                        class="modal-info-value"></span></div>
                <div class="modal-info-row"><span class="modal-info-label">Pelanggan</span><span id="modalCustomer"
                        class="modal-info-value"></span></div>
                <div class="modal-info-row"><span class="modal-info-label">Item</span><span id="modalItems"
                        class="modal-info-value" style="text-align:right"></span></div>
                <div class="modal-info-row"><span class="modal-info-label">Alamat</span><span id="modalAddress"
                        class="modal-info-value" style="text-align:right"></span></div>
                <div class="modal-info-row"><span class="modal-info-label">Waktu Pesan</span><span id="modalOrderTime"
                        class="modal-info-value"></span></div>
                <div class="modal-info-row"><span class="modal-info-label">Total</span><span id="modalTotal"
                        class="modal-info-value" style="color:#16a34a;font-weight:600"></span></div>
            </div>
            <div class="modal-notice">
                <strong>FCFS:</strong> Nomor antrean ditentukan berdasarkan waktu pesanan masuk, bukan waktu validasi.
            </div>
            <div class="modal-checklist">
                <p class="checklist-title">Checklist Validasi:</p>
                <label class="checklist-item">
                    <input type="checkbox" id="checkData" class="w-4 h-4 accent-blue-500">
                    <span>Data pesanan lengkap (nama, alamat, telepon, jumlah)</span>
                </label>
                <label class="checklist-item">
                    <input type="checkbox" id="checkWilayah" class="w-4 h-4 accent-blue-500">
                    <span>Alamat dalam jangkauan wilayah pengiriman</span>
                </label>
            </div>
            <div class="modal-actions">
                <button onclick="validasiPesanan('reject')" class="btn-reject">Tolak Pesanan</button>
                <button onclick="validasiPesanan('accept')" id="btnTerima" class="btn-accept" disabled>Terima
                    Pesanan</button>
            </div>
        </div>
    </div>

    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: #fff;
            border-radius: 14px;
            padding: 16px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .07);
            display: flex;
            align-items: center;
            gap: 14px;
            transition: box-shadow .2s;
        }

        .stat-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, .1);
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-icon--blue {
            background: #eff6ff;
            color: #3b82f6;
        }

        .stat-icon--green {
            background: #f0fdf4;
            color: #22c55e;
        }

        .stat-icon--orange {
            background: #fff7ed;
            color: #f97316;
        }

        .stat-icon--purple {
            background: #faf5ff;
            color: #a855f7;
        }

        .stat-label {
            font-size: 11px;
            color: #6b7280;
            margin: 0 0 4px;
        }

        .stat-value {
            font-size: 22px;
            font-weight: 700;
            margin: 0;
            line-height: 1;
        }

        .card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .07);
            overflow: hidden;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            padding: 14px 16px;
            border-bottom: 1px solid #f3f4f6;
        }

        .card-title {
            font-size: 15px;
            font-weight: 600;
            color: #1f2937;
            margin: 0;
        }

        .mb-6 {
            margin-bottom: 20px;
        }

        .filter-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .filter-btn {
            font-size: 11px;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            color: #6b7280;
            cursor: pointer;
            transition: background .15s, color .15s;
        }

        .filter-btn:hover {
            background: #f3f4f6;
        }

        .active-filter {
            background: #1d4ed8;
            color: #fff;
            border-color: #1d4ed8;
        }

        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .data-table th {
            background: #f9fafb;
            color: #374151;
            font-weight: 600;
            padding: 10px 12px;
            text-align: left;
            white-space: nowrap;
            border-bottom: 1px solid #e5e7eb;
        }

        .data-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #f3f4f6;
            color: #374151;
            vertical-align: middle;
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .data-table tr:hover td {
            background: #f9fafb;
        }

        .bottom-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .list-items {
            padding: 14px 16px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            font-size: 13px;
        }

        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .5);
            z-index: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .modal-backdrop.hidden {
            display: none;
        }

        .modal-box {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .2);
            width: 100%;
            max-width: 440px;
            padding: 24px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .modal-title {
            font-size: 17px;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 22px;
            color: #9ca3af;
            cursor: pointer;
            padding: 2px 6px;
            border-radius: 6px;
        }

        .modal-close:hover {
            color: #374151;
            background: #f3f4f6;
        }

        .modal-info-grid {
            background: #f9fafb;
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 14px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .modal-info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            font-size: 13px;
        }

        .modal-info-label {
            color: #6b7280;
            flex-shrink: 0;
        }

        .modal-info-value {
            font-weight: 600;
            color: #1f2937;
        }

        .modal-notice {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 10px;
            padding: 10px 12px;
            margin-bottom: 14px;
            font-size: 12px;
            color: #1d4ed8;
            line-height: 1.5;
        }

        .modal-checklist {
            margin-bottom: 18px;
        }

        .checklist-title {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin: 0 0 8px;
        }

        .checklist-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #374151;
            cursor: pointer;
            margin-bottom: 8px;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
        }

        .btn-reject {
            flex: 1;
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            font-weight: 600;
            padding: 10px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 13px;
            transition: background .2s;
        }

        .btn-reject:hover {
            background: #fee2e2;
        }

        .btn-accept {
            flex: 1;
            background: #22c55e;
            border: none;
            color: #fff;
            font-weight: 600;
            padding: 10px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 13px;
            transition: background .2s, opacity .2s;
        }

        .btn-accept:hover:not(:disabled) {
            background: #16a34a;
        }

        .btn-accept:disabled {
            opacity: .4;
            cursor: not-allowed;
        }

        @media (max-width:1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width:640px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            .stat-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
                padding: 14px;
            }

            .stat-value {
                font-size: 20px;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .filter-wrap {
                width: 100%;
            }

            .filter-btn {
                font-size: 10px;
                padding: 4px 9px;
            }

            .bottom-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width:380px) {
            .stat-value {
                font-size: 17px;
            }

            .stat-label {
                font-size: 10px;
            }
        }
    </style>

    <script>
        let currentOrderId = null;
        let allOrders = [];
        let currentFilter = 'all';

        function filterStatus(status) {
            currentFilter = status;
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active-filter'));
            document.getElementById('filter-' + status).classList.add('active-filter');
            renderTable();
        }

        function renderTable() {
            const filtered = currentFilter === 'all' ? allOrders : allOrders.filter(o => o.status === currentFilter);
            const statusBadge = {
                'pending': '<span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs">Menunggu</span>',
                'confirmed': '<span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">Dikonfirmasi</span>',
                'on_delivery': '<span class="bg-purple-100 text-purple-700 px-2 py-1 rounded-full text-xs">Dikirim</span>',
                'completed': '<span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">Selesai</span>',
                'cancelled': '<span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs">Dibatalkan</span>',
                'delivered': '<span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">Terkirim</span>',
            };
            let rows = '';
            filtered.forEach(order => {
                let itemNames = '';
                order.items.forEach(item => {
                    itemNames += item.quantity + 'x ' + (item.product?.name ?? 'Produk Dihapus') + ', ';
                });
                const aksiButton = order.status === 'pending' ?
                    `<button onclick='bukaModal(${JSON.stringify(order)})' class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded-lg">Validasi</button>` :
                    '-';
                const waktuPesan = new Date(order.created_at).toLocaleString('id-ID', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
                const kurirNama = order.courier?.user?.name ?? '-';
                const nomorAntrean = order.queue_number ?
                    `<span class="bg-gray-800 text-white text-xs px-2 py-1 rounded-full">#${order.queue_number}</span>` :
                    '-';
                rows += `<tr>
                    <td style="white-space:nowrap">${order.order_code}</td>
                    <td>${order.user?.name ?? '-'}</td>
                    <td style="max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis" title="${itemNames}">${itemNames}</td>
                    <td style="white-space:nowrap;color:#6b7280">${waktuPesan}</td>
                    <td style="text-align:center">${nomorAntrean}</td>
                    <td>${statusBadge[order.status] ?? order.status}</td>
                    <td>${kurirNama}</td>
                    <td style="text-align:center">${aksiButton}</td>
                </tr>`;
            });
            document.getElementById('orderTable').innerHTML = rows ||
                '<tr><td colspan="8" style="text-align:center;padding:20px;color:#9ca3af">Tidak ada pesanan</td></tr>';
        }

        function loadDashboard() {
            fetch("/admin/dashboard/data").then(r => r.json()).then(data => {
                document.getElementById('totalOrders').innerText = data.totalOrders;
                document.getElementById('todayIncome').innerText = 'Rp ' + data.todayIncome;
                document.getElementById('activeOrders').innerText = data.activeOrders;
                document.getElementById('courierOnline').innerText = data.courierOnline + '/' + data.totalCourier;
                allOrders = data.orders || [];
                renderTable();
                let courierHtml = '';
                (data.activeCouriers || []).forEach(courier => {
                    let totalTask = allOrders.filter(o => o.assigned_courier_id === courier.id && o
                        .status !== 'completed').length;
                    courierHtml += `<div style="border:1px solid #e5e7eb;border-radius:10px;padding:12px">
                        <p style="font-weight:600;margin:0 0 2px">${courier.user?.name ?? '-'}</p>
                        <p style="color:#22c55e;font-size:11px;margin:0 0 2px">● Online</p>
                        <p style="color:#6b7280;font-size:12px;margin:0">Pesanan aktif: ${totalTask}</p>
                    </div>`;
                });
                document.getElementById('courierList').innerHTML = courierHtml ||
                    '<p style="color:#9ca3af;font-size:13px">Tidak ada kurir online</p>';
                let inventoryHtml = '';
                data.products?.forEach(product => {
                    let color = product.stock <= 10 ? '#dc2626' : product.stock <= 20 ? '#d97706' :
                        '#16a34a';
                    let icon = product.stock <= 10 ? '!' : product.stock <= 20 ? '~' : 'v';
                    inventoryHtml += `<div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid #f3f4f6">
                        <span style="font-weight:500">${product.name}</span>
                        <span style="color:${color};font-size:12px">${product.stock} pcs · Rp${parseInt(product.price).toLocaleString('id-ID')}</span>
                    </div>`;
                });
                document.getElementById('inventoryList').innerHTML = inventoryHtml;
            });
        }

        function bukaModal(order) {
            currentOrderId = order.id;
            document.getElementById('checkData').checked = false;
            document.getElementById('checkWilayah').checked = false;
            updateTombolTerima();
            document.getElementById('modalOrderCode').innerText = order.order_code ?? '-';
            document.getElementById('modalCustomer').innerText = order.user?.name ?? '-';
            let itemNames = '';
            order.items.forEach(item => {
                itemNames += item.quantity + 'x ' + (item.product?.name ?? 'Produk Dihapus') + ' ';
            });
            document.getElementById('modalItems').innerText = itemNames;
            const alamat = order.address ? `${order.address.label ?? ''} - ${order.address.address ?? ''}` : '-';
            document.getElementById('modalAddress').innerText = alamat;
            const waktu = new Date(order.created_at).toLocaleString('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('modalOrderTime').innerText = waktu;
            const total = order.total_amount ? 'Rp ' + parseInt(order.total_amount).toLocaleString('id-ID') : '-';
            document.getElementById('modalTotal').innerText = total;
            document.getElementById('modalValidasi').classList.remove('hidden');
        }

        function tutupModal() {
            document.getElementById('modalValidasi').classList.add('hidden');
            currentOrderId = null;
        }

        document.getElementById('checkData').addEventListener('change', updateTombolTerima);
        document.getElementById('checkWilayah').addEventListener('change', updateTombolTerima);

        function updateTombolTerima() {
            const ok = document.getElementById('checkData').checked && document.getElementById('checkWilayah').checked;
            document.getElementById('btnTerima').disabled = !ok;
        }

        function validasiPesanan(action) {
            if (!currentOrderId) return;
            fetch(`/admin/orders/${currentOrderId}/validate`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        action: action
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showToast(action === 'accept' ? `Pesanan diterima - Antrean: ${data.queue_number}` :
                            'Pesanan ditolak', 'success');
                        tutupModal();
                        loadDashboard();
                    } else {
                        showToast('Gagal: ' + data.message, 'error');
                    }
                })
                .catch(() => showToast('Terjadi kesalahan, coba lagi.', 'error'));
        }

        document.getElementById('modalValidasi').addEventListener('click', function(e) {
            if (e.target === this) tutupModal();
        });

        loadDashboard();
        setInterval(loadDashboard, 5000);
    </script>

@endsection
