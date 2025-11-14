<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourierController extends Controller
{
    // 🧭 Tampilkan daftar kurir + filter
    public function index(Request $request)
    {
        $status = $request->input('status');
        $keyword = $request->input('keyword');

        $query = Courier::with('user');

        if ($status) {
            $query->where('status', $status);
        }

        if ($keyword) {
            $query->whereHas('user', function ($q) use ($keyword) {
                $q->where('name', 'ILIKE', "%{$keyword}%")
                  ->orWhere('email', 'ILIKE', "%{$keyword}%");
            });
        }

        $couriers = $query->latest()->paginate(10);

        return view('admin.couriers.index', compact('couriers', 'status', 'keyword'));
    }

    // ➕ Form tambah kurir
    public function create()
    {
        $users = User::all();
        return view('admin.couriers.create', compact('users'));
    }

    // 💾 Simpan kurir baru
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'vehicle_info' => 'nullable|string|max:100',
            'status' => 'required|string|max:50',
        ]);

        Courier::create([
            'id' => (string) Str::uuid(),
            'user_id' => $request->user_id,
            'vehicle_info' => $request->vehicle_info,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.couriers.index')->with('success', 'Kurir berhasil ditambahkan.');
    }

    // ✏️ Form edit kurir
    public function edit(Courier $courier)
    {
        $users = User::all();
        return view('admin.couriers.edit', compact('courier', 'users'));
    }

    // 🔄 Update data kurir
    public function update(Request $request, Courier $courier)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'vehicle_info' => 'nullable|string|max:100',
            'status' => 'required|string|max:50',
        ]);

        $courier->update($request->only('user_id', 'vehicle_info', 'status'));

        return redirect()->route('admin.couriers.index')->with('success', 'Data kurir berhasil diperbarui.');
    }

    // ❌ Hapus kurir
    public function destroy(Courier $courier)
    {
        $courier->delete();

        return redirect()->route('admin.couriers.index')->with('success', 'Kurir berhasil dihapus.');
    }
}
