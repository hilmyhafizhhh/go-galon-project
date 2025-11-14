<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('customer.profile.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255',
                'email' => 'required|email',
                'alamat' => 'nullable|string',
                'no_hp' => 'nullable|string',
            ]);

            $user->update($request->only(['name', 'username', 'email', 'alamat', 'no_hp']));
        } else {
            // Tangani kasus ketika objek pengguna `null`
        }

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui.'
        ]);
    }
}
