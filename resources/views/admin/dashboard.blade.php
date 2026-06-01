@extends('layout')

@section('content')
    <h1 class="text-2xl font-bold text-gray-800 mb-6">DASHBOARD</h1>

    {{-- STATISTIK CARDS --}}
    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-xl shadow text-center">
            <p class="text-gray-500 text-sm">Total Pesanan Hari Ini</p>
            <h2 id="totalOrders" class="text-2xl font-bold text-blue-600">0</h2>
        </div>
        <div class="bg-white p-4 rounded-xl shadow text-center">
            <p class="text-gray-500 text-sm">Pendapatan Hari Ini</p>
            <h2 id="todayIncome" class="text-2xl font-bold text-green-600">Rp 0</h2>
        </div>
        <div class="bg-white p-4 rounded-xl shadow text-center">
            <p class="text-gray-500 text-sm">Pesanan Aktif Hari Ini</p>
            <h2 id="activeOrders" class="text-2xl font-bold text-orange-500">0</h2>
        </div>
        <div class="bg-white p-4 rounded-xl shadow text-center">
            <p class="text-gray-500 text-sm">Kurir Online</p>
            <h2 id="courierOnline" class="text-2xl font-bold text-purple-600">0/0</h2>
        </div>
    </div>

    {{-- TABEL PESANAN --}}
    <div class="bg-white p-4 rounded-xl shadow mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-semibold text-lg">Daftar Pesanan Hari Ini</h2>

            {{-- FILTER STATUS --}}
            <div class="flex gap-2">
                <button onclick="filterStatus('all')" id="filter-all"
                    class="filter-btn active-filter text-xs px-3 py-1.5 rounded-lg border font-semibold transition">
                    Semua
                </button>
                <button onclick="filterStatus('pending')" id="filter-pending"
                    class="filter-btn text-xs px-3 py-1.5 rounded-lg border font-semibold transition">
                    Menunggu
                </button>
                <button onclick="filterStatus('confirmed')" id="filter-confirmed"
                    class="filter-btn text-xs px-3 py-1.5 rounded-lg border font-semibold transition">
                    Dikonfirmasi
                </button>
                <button onclick="filterStatus('on_delivery')" id="filter-on_delivery"
                    class="filter-btn text-xs px-3 py-1.5 rounded-lg border font-semibold transition">
                    Dikirim
                </button>
                <button onclick="filterStatus('completed')" id="filter-completed"
                    class="filter-btn text-xs px-3 py-1.5 rounded-lg border font-semibold transition">
                    Selesai
                </button>
                <button onclick="filterStatus('cancelled')" id="filter-cancelled"
                    class="filter-btn text-xs px-3 py-1.5 rounded-lg border font-semibold transition">
                    Dibatalkan
                </button>
            </div>
        </div>

        <table class="min-w-full border text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="border p-2">ID</th>
                    <th class="border p-2">Customer</th>
                    <th class="border p-2">Item</th>
                    <th class="border p-2">Waktu Pesan</th>
                    <th class="border p-2">No. Antrean</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Kurir</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody id="orderTable"></tbody>
        </table>
    </div>

    <div class="grid grid-cols-2 gap-6 mt-6">
        <div class="bg-white p-4 rounded-xl shadow">
            <h2 class="font-semibold mb-4">Kurir Aktif</h2>
            <div id="courierList" class="space-y-2 text-sm"></div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow">
            <h2 class="font-semibold mb-4">Inventory Galon</h2>
            <div id="inventoryList" class="space-y-2 text-sm"></div>
        </div>
    </div>

    {{-- MODAL VALIDASI PESANAN --}}
    <div id="modalValidasi" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 p-6">

            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Validasi Pesanan</h3>
                <button onclick="tutupModal()" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
            </div>

            <div class="bg-gray-50 rounded-xl p-4 mb-4 text-sm space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-500">ID Pesanan</span>
                    <span id="modalOrderCode" class="font-semibold"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Pelanggan</span>
                    <span id="modalCustomer" class="font-semibold"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Item</span>
                    <span id="modalItems" class="font-semibold text-right max-w-xs"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Alamat</span>
                    <span id="modalAddress" class="font-semibold text-right max-w-xs"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Waktu Pesan</span>
                    <span id="modalOrderTime" class="font-semibold"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Total</span>
                    <span id="modalTotal" class="font-semibold text-green-600"></span>
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-xl p-3 mb-4 text-xs text-blue-700">
                <strong>⏱ FCFS:</strong> Nomor antrean ditentukan berdasarkan waktu pesanan masuk, bukan waktu validasi.
            </div>

            <div class="mb-4">
                <p class="text-sm font-semibold text-gray-700 mb-2">Checklist Validasi:</p>
                <label class="flex items-center gap-2 text-sm mb-2 cursor-pointer">
                    <input type="checkbox" id="checkData" class="w-4 h-4 accent-blue-500">
                    <span>Data pesanan lengkap (nama, alamat, telepon, jumlah)</span>
                </label>
                <label class="flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" id="checkWilayah" class="w-4 h-4 accent-blue-500">
                    <span>Alamat dalam jangkauan wilayah pengiriman</span>
                </label>
            </div>

            <div class="flex gap-3">
                <button onclick="validasiPesanan('reject')"
                    class="flex-1 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 font-semibold py-2 px-4 rounded-xl transition">
                    ✕ Tolak Pesanan
                </button>
                <button onclick="validasiPesanan('accept')" id="btnTerima"
                    class="flex-1 bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-xl transition disabled:opacity-40 disabled:cursor-not-allowed">
                    ✓ Terima Pesanan
                </button>
            </div>
        </div>
    </div>

    <style>
        .filter-btn {
            background: #f9fafb;
            color: #6b7280;
            border-color: #e5e7eb;
        }

        .filter-btn:hover {
            background: #f3f4f6;
        }

        .active-filter {
            background: #1d4ed8;
            color: #fff;
            border-color: #1d4ed8;
        }
    </style>

    <script>
        let currentOrderId = null;
        let allOrders = [];
        let currentFilter = 'all';

        function showToast(message, type = 'success') {
            const container = document.getElementById('ef-toast-container');
            const t = document.createElement('div');
            t.className = `ef-toast ef-toast--${type}`;
            const icon = type === 'success' ?
                `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>` :
                `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>`;
            t.innerHTML = `${icon}<span>${message}</span>`;
            container.prepend(t);
            requestAnimationFrame(() => t.classList.add('ef-toast--show'));
            setTimeout(() => {
                t.classList.remove('ef-toast--show');
                setTimeout(() => t.remove(), 400);
            }, 2500);
        }

        function filterStatus(status) {
            currentFilter = status;

            // Update active button
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active-filter');
            });
            document.getElementById('filter-' + status).classList.add('active-filter');

            // Filter dan render tabel
            renderTable();
        }

        function renderTable() {
            const filtered = currentFilter === 'all' ?
                allOrders :
                allOrders.filter(o => o.status === currentFilter);

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

                // Nama kurir yang assigned
                const kurirNama = order.courier?.user?.name ?? '-';

                // Nomor antrean
                const nomorAntrean = order.queue_number ?
                    `<span class="bg-gray-800 text-white text-xs px-2 py-1 rounded-full">#${order.queue_number}</span>` :
                    '-';

                rows += `
                    <tr>
                        <td class="border p-2 text-xs">${order.order_code}</td>
                        <td class="border p-2">${order.user?.name ?? '-'}</td>
                        <td class="border p-2 text-xs">${itemNames}</td>
                        <td class="border p-2 text-xs text-gray-500">${waktuPesan}</td>
                        <td class="border p-2 text-center">${nomorAntrean}</td>
                        <td class="border p-2">${statusBadge[order.status] ?? order.status}</td>
                        <td class="border p-2">${kurirNama}</td>
                        <td class="border p-2 text-center">${aksiButton}</td>
                    </tr>
                `;
            });

            document.getElementById('orderTable').innerHTML = rows ||
                '<tr><td colspan="8" class="text-center py-4 text-gray-400">Tidak ada pesanan</td></tr>';
        }

        function loadDashboard() {
            fetch("/admin/dashboard/data")
                .then(response => response.json())
                .then(data => {
                    document.getElementById('totalOrders').innerText = data.totalOrders;
                    document.getElementById('todayIncome').innerText = 'Rp ' + data.todayIncome;
                    document.getElementById('activeOrders').innerText = data.activeOrders;
                    document.getElementById('courierOnline').innerText = data.courierOnline + '/' + data.totalCourier;

                    // Simpan semua orders dan render
                    allOrders = data.orders || [];
                    renderTable();

                    // Kurir aktif
                    let courierHtml = '';
                    (data.activeCouriers || []).forEach(courier => {
                        let totalTask = allOrders.filter(order =>
                            order.assigned_courier_id === courier.id &&
                            order.status !== 'completed'
                        ).length;
                        courierHtml += `
                            <div class="border rounded p-3">
                                <p><strong>${courier.user?.name ?? '-'}</strong></p>
                                <p class="text-green-600 text-xs">Online</p>
                                <p class="text-xs">Pesanan aktif: ${totalTask}</p>
                            </div>
                        `;
                    });
                    document.getElementById('courierList').innerHTML = courierHtml ||
                        '<p class="text-gray-400 text-xs">Tidak ada kurir online</p>';

                    // Inventory
                    let inventoryHtml = '';
                    data.products?.forEach(product => {
                        let color = product.stock <= 10 ? 'text-red-600' : product.stock <= 20 ?
                            'text-yellow-600' : 'text-green-600';
                        let icon = product.stock <= 10 ? '❌' : product.stock <= 20 ? '⚠️' : '✅';
                        inventoryHtml += `
                            <p>${product.name} → <span class="${color}">Stock: ${product.stock} | Rp.${parseInt(product.price).toLocaleString('id-ID')}</span> ${icon}</p>
                        `;
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
            const dataOk = document.getElementById('checkData').checked;
            const wilayahOk = document.getElementById('checkWilayah').checked;
            document.getElementById('btnTerima').disabled = !(dataOk && wilayahOk);
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
                        const msg = action === 'accept' ?
                            `Pesanan diterima — Nomor Antrean: ${data.queue_number}` :
                            `Pesanan ditolak`;
                        showToast(msg, 'success');
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

    <div id="ef-toast-container"></div>
@endsection
