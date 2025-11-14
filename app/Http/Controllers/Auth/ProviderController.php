<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Verified;

class ProviderController extends Controller
{
    public function redirect() {
        return Socialite::driver('google')->with(['prompt' => 'select_account'])->redirect();
    }

    public function callback() {
        $googleUser = Socialite::driver('google')->user();

        $username = explode('@', $googleUser->email)[0];
        $originalUsername = $username;
        $counter = 1;

        // Pastikan username unik
        while (User::where('username', $username)->exists()) {
            $username = $originalUsername . $counter++;
        }

        // Buat atau update user berdasarkan google_id
        $user = User::updateOrCreate(
            ['google_id' => $googleUser->id],
            [
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'username' => $username,
                'google_id' => $googleUser->id,
                'google_token' => $googleUser->token,
            ]
        );

        Auth::login($user);

        // Tandai sebagai verified jika belum
        if (is_null($user->email_verified_at)) {
            $user->email_verified_at = now();
            $user->save();
            event(new Verified($user));
        }

        if(!$user->hasAnyRole(['admin', 'customer', 'courier'])) {
            $user->assignRole('customer');
        };

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('courier')) {
            return redirect()->route('courier.home');
        } else {
            return redirect()->route('customer.home');
        }
    }
}
