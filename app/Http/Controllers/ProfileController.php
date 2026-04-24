<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tentukan prefix route berdasarkan role user yang login.
     * Dipakai untuk redirect setelah update/delete.
     */
    private function rolePrefix(): string
    {
        $user = Auth::user();

        if ($user->hasRole('admin'))   return 'admin';
        if ($user->hasRole('courier')) return 'courier';

        return 'customer';
    }

    /**
     * Tampilkan halaman edit profil.
     * Satu view untuk semua role — DRY & mudah dirawat.
     * Kalau nanti perlu beda tampilan per role, tinggal ganti ke match() di bawah.
     */
    public function show(Request $request): View
    {
        // return view('profile.show', [
        //     'user' => $request->user(),
        // ]);

        // Kalau nanti mau view berbeda per role:
        $view = match($this->rolePrefix()) {
            'admin'   => 'admin.profile.show',
            'courier' => 'courier.profile.show',
            default   => 'customer.profile.show',
        };
        return view($view, ['user' => $request->user()]);
    }

    /**
     * Update informasi profil user (berlaku untuk semua role).
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name'             => ['required', 'string', 'max:100'],
            'username'         => ['required', 'string', 'max:100', Rule::unique('users')->ignore($user->id)],
            'email'            => ['required', 'email', 'max:100', Rule::unique('users')->ignore($user->id)],
            'phone'            => ['nullable', 'string', 'max:20'],
            'current_password' => ['nullable', 'string'],
            'password'         => ['nullable', 'confirmed', Password::min(8)],
        ]);

        // Ganti password: wajib verifikasi password lama
        if ($request->filled('password')) {
            if (! $request->filled('current_password') || ! Hash::check($request->current_password, $user->password)) {
                return back()
                    ->withErrors(['current_password' => 'Password saat ini tidak sesuai.'])
                    ->withInput();
            }
            $user->password = Hash::make($validated['password']);
        }

        // Reset verifikasi email jika email diganti
        if ($user->email !== $validated['email']) {
            $user->email_verified_at = null;
        }

        $user->fill([
            'name'     => $validated['name'],
            'username' => $validated['username'],
            'email'    => $validated['email'],
            'phone'    => $validated['phone'] ?? null,
        ]);

        $user->save();

        // Redirect kembali ke halaman profil sesuai role
        $prefix = $this->rolePrefix();
        return Redirect::route("{$prefix}.profile")->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Hapus akun user.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Validasi password hanya untuk user yang punya password (skip untuk OAuth-only)
        if (! is_null($user->password)) {
            $request->validateWithBag('userDeletion', [
                'password' => ['required', 'current_password'],
            ]);
        }

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}