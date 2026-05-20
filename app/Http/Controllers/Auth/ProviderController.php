<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProviderController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (InvalidStateException $e) {
            // State mismatch — redirect ulang ke login, jangan crash
            return redirect('/login')
                ->withErrors(['google' => 'Sesi login Google kedaluwarsa, silakan coba lagi.']);
        } catch (\Exception $e) {
            return redirect('/login')
                ->withErrors(['google' => 'Login Google gagal: ' . $e->getMessage()]);
        }

        // Buat username unik dari email
        $username = explode('@', $googleUser->email)[0];
        $username = preg_replace('/[^a-zA-Z0-9_]/', '', $username); // sanitize
        $originalUsername = $username;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $originalUsername . $counter++;
        }

        // Buat atau update user berdasarkan google_id
        $user = User::updateOrCreate(
            ['google_id' => $googleUser->id],
            [
                'name'               => $googleUser->name,
                'email'              => $googleUser->email,
                'username'           => $username,
                'google_token'       => $googleUser->token,
                'email_verified_at'  => now(), // Google sudah verifikasi email-nya
                'password'           => null,
            ]
        );

        // Assign role default kalau belum punya role
        if ($user->getRoleNames()->isEmpty()) {
            $user->assignRole('customer');
        }

        Auth::login($user, remember: true);

        return redirect()->intended(
            $user->hasRole('admin')   ? route('admin.dashboard') :
            ($user->hasRole('courier') ? route('courier.home')    :
                                         route('customer.home'))
        );
    }
}