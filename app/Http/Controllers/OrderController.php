<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter filter dari request
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $keyword = $request->input('keyword');

        // Query dasar
        $query = Order::with('user');

        // Filter berdasarkan status
        if ($status) {
            $query->where('status', $status);
        }

        // Filter berdasarkan rentang tanggal (created_at)
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Filter berdasarkan nama pelanggan
        if ($keyword) {
            $query->whereHas('user', function ($q) use ($keyword) {
                $q->where('name', 'ILIKE', "%{$keyword}%");
            });
        }

        // Ambil data hasil filter (atau semua jika tanpa filter)
        $orders = $query->latest()->paginate(10);

        return view('admin.orders.index', compact('orders', 'status', 'startDate', 'endDate', 'keyword'));
    }
}
