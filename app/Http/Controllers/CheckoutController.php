<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Address;

class CheckoutController extends Controller
{
    public function index()
    {
        $order = Order::with(['items' => function ($q) {
            $q->where('is_selected', true);
        }, 'items.product'])
            ->where('user_id', auth()->id())
            ->where('status', 'draft')
            ->first();

        if (!$order || $order->items->isEmpty()) {
            return redirect()->route('customer.cart');
        }

        $addresses = Address::where('user_id', auth()->id())
            ->orderByDesc('is_default')
            ->get();



        return view('checkout.index', compact('order', 'addresses'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required'
        ]);

        $order = Order::with('items.product')
            ->where('user_id', auth()->id())
            ->where('status', 'draft')
            ->first();

        $items = $order->items->where('is_selected', true);

        if ($items->isEmpty()) {
            return back()->with('error', 'Tidak ada item dipilih');
        }

        // 🔥 hapus item yang tidak dipilih
        $order->items()->where('is_selected', false)->delete();

        $total = $items->sum('subtotal');

        $order->update([
            'total_amount' => $total,
            'status' => 'pending',
            'address_id' => $request->address_id,
            'payment_method' => $request->payment_method
        ]);

        return redirect()->route('customer.checkout.success', $order->id);
    }

    public function addressPicker()
    {
        $addresses = Address::where('user_id', auth()->id())
            ->orderByDesc('is_default')->get();
        return view('checkout.address-picker', compact('addresses'));
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
            'label'   => 'required|string|max:100',
            'address' => 'required|string',
        ]);
        if ($request->boolean('is_default')) {
            Address::where('user_id', auth()->id())->update(['is_default' => false]);
        }
        $address->update([
            'label'      => $request->label,
            'address'    => $request->address,
            'is_default' => $request->boolean('is_default'),
        ]);
        return redirect()->back()->with('success', 'Alamat berhasil diperbarui');
    }

    public function destroy(Address $address)
    {
        abort_if($address->user_id !== auth()->id(), 403);
        $address->delete();
        return redirect()->route('customer.checkout.address-picker');
    }
}
