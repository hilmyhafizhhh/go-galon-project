<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function create()
    {
        return view('customer.address.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|max:100',
            'address' => 'required'
        ]);

        // cek apakah ini alamat pertama
        $isFirst = Address::where('user_id', auth()->id())->doesntExist();

        Address::create([
            'user_id' => auth()->id(),
            'label' => $request->label,
            'address' => $request->address,
            'is_default' => $isFirst // otomatis default kalau pertama
        ]);

        return redirect()->route('customer.checkout')
            ->with('success', 'Alamat berhasil ditambahkan');
    }
}
