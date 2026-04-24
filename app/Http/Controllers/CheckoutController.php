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

        $order = Order::with('items')
            ->where('user_id', auth()->id())
            ->where('status', 'draft')
            ->first();

        if (!$order) {
            return redirect()->route('customer.cart');
        }

        $items = $order->items->where('is_selected', true);

        if ($items->isEmpty()) {
            return back()->with('error', 'Tidak ada item dipilih');
        }

        $total = $items->sum('subtotal');

        $order->update([
            'total_amount' => $total,
            'status' => 'pending',
            'address_id' => $request->address_id,
            'payment_method' => $request->payment_method
        ]);

        return redirect('/checkout/success');
    }
}
