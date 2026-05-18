<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function create()
    {
        return view('customer.address.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'label'   => 'required|max:100',
            'address' => 'required',
        ]);

        $userId      = auth()->id();
        $isFirst     = Address::where('user_id', $userId)->doesntExist();
        $makeDefault = $isFirst || $request->boolean('is_default');

        DB::transaction(function () use ($userId, $request, $makeDefault) {
            if ($makeDefault) {
                Address::where('user_id', $userId)
                    ->where('is_default', true)
                    ->update(['is_default' => false]);
            }

            Address::create([
                'user_id'    => $userId,
                'label'      => $request->label,
                'address'    => $request->address,
                'latitude'   => $request->latitude  ?? null,
                'longitude'  => $request->longitude ?? null,
                'is_default' => $makeDefault,
            ]);
        });

        return redirect()->route('customer.checkout')
            ->with('success', 'Alamat berhasil ditambahkan');
    }

    public function edit(Address $address)
    {
        // Pastikan alamat milik user yang login
        abort_if($address->user_id !== auth()->id(), 403);

        return view('customer.address.edit', compact('address'));
    }

    public function update(Request $request, Address $address)
    {
        abort_if($address->user_id !== auth()->id(), 403);

        $request->validate([
            'label'   => 'required|max:100',
            'address' => 'required',
        ]);

        $userId      = auth()->id();
        $makeDefault = $request->boolean('is_default');

        DB::transaction(function () use ($userId, $request, $address, $makeDefault) {
            // Jika dijadikan default, reset alamat lain terlebih dahulu
            if ($makeDefault) {
                Address::where('user_id', $userId)
                    ->where('id', '!=', $address->id)
                    ->where('is_default', true)
                    ->update(['is_default' => false]);
            }

            $address->update([
                'label'      => $request->label,
                'address'    => $request->address,
                'latitude'   => $request->latitude  ?? $address->latitude,
                'longitude'  => $request->longitude ?? $address->longitude,
                'is_default' => $makeDefault,
            ]);
        });

        return redirect()->route('customer.checkout')
            ->with('success', 'Alamat berhasil diperbarui');
    }

    public function destroy(Address $address)
    {
        abort_if($address->user_id !== auth()->id(), 403);

        $wasDefault = $address->is_default;
        $userId     = auth()->id();

        DB::transaction(function () use ($address, $wasDefault, $userId) {
            $address->delete();

            // Jika alamat yang dihapus adalah default,
            // otomatis jadikan alamat terlama sebagai default baru
            if ($wasDefault) {
                Address::where('user_id', $userId)
                    ->oldest()
                    ->first()
                    ?->update(['is_default' => true]);
            }
        });

        return redirect()->route('customer.checkout')
            ->with('success', 'Alamat berhasil dihapus');
    }

    public function select()
    {
        $addresses = auth()->user()->addresses()->orderByDesc('is_default')->get();
        return view('customer.address.select', compact('addresses'));
    }
}
