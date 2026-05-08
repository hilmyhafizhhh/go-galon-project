<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AddressController extends Controller
{
    /**
     * Store a new address.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label'     => ['required', 'string', 'max:100'],
            'address'   => ['required', 'string'],
            'latitude'  => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'is_default'=> ['boolean'],
        ]);

        $user = Auth::user();

        // Kalau ini default, lepas default dari yang lain dulu
        if (!empty($validated['is_default'])) {
            $user->addresses()->update(['is_default' => false]);
        }

        // Kalau belum punya alamat sama sekali, jadikan default otomatis
        $isFirst = $user->addresses()->count() === 0;

        $user->addresses()->create([
            'label'      => $validated['label'],
            'address'    => $validated['address'],
            'latitude'   => $validated['latitude'] ?? null,
            'longitude'  => $validated['longitude'] ?? null,
            'is_default' => $isFirst || !empty($validated['is_default']),
        ]);

        return back()->with('success', 'Alamat berhasil ditambahkan.');
    }

    /**
     * Update an existing address.
     */
    public function update(Request $request, Address $address)
    {
        // Pastikan address milik user yang login
        abort_if($address->user_id !== Auth::id(), 403);

        $validated = $request->validate([
            'label'     => ['required', 'string', 'max:100'],
            'address'   => ['required', 'string'],
            'latitude'  => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'is_default'=> ['boolean'],
        ]);

        if (!empty($validated['is_default'])) {
            Auth::user()->addresses()->where('id', '!=', $address->id)
                ->update(['is_default' => false]);
        }

        $address->update($validated);

        return back()->with('success', 'Alamat berhasil diperbarui.');
    }

    /**
     * Set an address as the default.
     */
    public function setDefault(Address $address)
    {
        abort_if($address->user_id !== Auth::id(), 403);

        Auth::user()->addresses()->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return back()->with('success', 'Alamat utama berhasil diubah.');
    }

    /**
     * Delete an address.
     */
    public function destroy(Address $address)
    {
        abort_if($address->user_id !== Auth::id(), 403);

        $wasDefault = $address->is_default;
        $address->delete();

        // Kalau yang dihapus adalah default, set yang pertama sebagai default baru
        if ($wasDefault) {
            Auth::user()->addresses()->oldest()->first()?->update(['is_default' => true]);
        }

        return back()->with('success', 'Alamat berhasil dihapus.');
    }
}