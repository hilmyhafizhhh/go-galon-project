<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash; //nambah ini
use Illuminate\Support\Facades\DB;

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
        // $users = User::all(); sementara dimatikan
        return view('admin.couriers.create');
        // return view('admin.couriers.create', compact('users')); sementara dimatikan
    }

    // 💾 Simpan kurir baru
    public function store(Request $request)
    {
        // Validasi input akun user baru sekaligus data kurir
        $request->validate([
            'name'         => 'required|string|max:255',
            'phone'        => 'required|string|max:20',
            'username'     => 'required|string|max:255|unique:users,username',
            'email'        => 'required|string|email|max:255|unique:users,email',
            'password'     => 'required|string|min:8',
            'vehicle_info' => 'nullable|string|max:100',
            'status'       => 'required|string|max:50',
        ], [
            'username.unique' => 'Username ini sudah terdaftar, silakan gunakan nama lain.',
            'email.unique'    => 'Alamat email ini sudah digunakan oleh akun lain.',
        ]);


        // 1. Buat akun User baru khusus untuk kurir
        $user = User::create([
            'name'     => $request->name,
            'username' => $request->username, // <-- Tambahan
            'email'    => $request->email,
            'phone'    => $request->phone,
            // 'password' => Hash::make($request->password),
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            // 'role'     => 'courier', // Asumsi kolom role di database Anda bernama 'role'
        ]);


        // // 2. Berikan Role 'courier' menggunakan fungsi bawaan Spatie
        // $user->assignRole('courier');
        $role = DB::table('roles')->where('name', 'courier')->first();

        if ($role) {
            DB::table('model_has_roles')->insert([
                'role_id'    => $role->id,         
                'model_type' => 'App\Models\User', // Wajib sesuai dengan Model User
                'model_id'   => $user->id,         // ID user baru (UUID)
            ]);
        }

        // 3. Masukkan data ke tabel couriers menggunakan ID user yang baru dibuat
        Courier::create([
            'id'           => (string) Str::uuid(),
            'user_id'      => $user->id,
            'vehicle_info' => $request->vehicle_info,
            'status'       => $request->status,
        ]);

        return redirect()->route('admin.couriers.index')->with('success', 'Akun & data kurir berhasil ditambahkan.');
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'user_id' => 'required|exists:users,id',
    //         'vehicle_info' => 'nullable|string|max:100',
    //         'status' => 'required|string|max:50',
    //     ]);

    //     Courier::create([
    //         'id' => (string) Str::uuid(),
    //         'user_id' => $request->user_id,
    //         'vehicle_info' => $request->vehicle_info,
    //         'status' => $request->status,
    //     ]);

    //     return redirect()->route('admin.couriers.index')->with('success', 'Kurir berhasil ditambahkan.');
    // } sementara dimatikan

    // ✏️ Form edit kurir
    public function edit(Courier $courier)
    {
        return view('admin.couriers.edit', compact('courier'));
        // $users = User::all();
        // return view('admin.couriers.edit', compact('courier', 'users')); hapus sementara
    }

    // 🔄 Update data kurir
    public function update(Request $request, Courier $courier)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'phone'        => 'required|string|max:20',
            'username'     => 'required|string|max:255|unique:users,username,' . $courier->user_id,
            'email'        => 'required|string|email|max:255|unique:users,email,' . $courier->user_id,
            'vehicle_info' => 'nullable|string|max:100',
            'status'       => 'required|string|max:50',
        ]);

        // 1. Update data akun User (nama & email)
        $courier->user->update([
            'name'  => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone'    => $request->phone,
        ]);

        // 2. Update data operasional kurir
        $courier->update([
            'vehicle_info' => $request->vehicle_info,
            'status'       => $request->status,
        ]);

        return redirect()->route('admin.couriers.index')->with('success', 'Data kurir berhasil diperbarui.');
    }

    // public function update(Request $request, Courier $courier)
    // {
    //     $request->validate([
    //         'user_id' => 'required|exists:users,id',
    //         'vehicle_info' => 'nullable|string|max:100',
    //         'status' => 'required|string|max:50',
    //     ]);

    //     $courier->update($request->only('user_id', 'vehicle_info', 'status'));

    //     return redirect()->route('admin.couriers.index')->with('success', 'Data kurir berhasil diperbarui.');
    // } dimatikan sementara

    // ❌ Hapus kurir
    public function destroy(Courier $courier)
    {
        $courier->delete();

        return redirect()->route('admin.couriers.index')->with('success', 'Kurir berhasil dihapus.');
    }
}
