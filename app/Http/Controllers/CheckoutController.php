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

    // CheckoutController.php — method process()

    public function process(Request $request)
    {

        // dd($request->all());

        $order = Order::where('user_id', auth()->id())
            ->where('status', 'draft')
            ->with('items')
            ->firstOrFail();

        // ── CEK STOK PRODUK ──
        foreach ($order->items as $item) {

            $product = $item->product;
            
            // cek stok
            if ($item->quantity > $product->stock) {

                return redirect()->back()->with(
                    'error',
                    'Stok produk ' . $product->name . ' tidak mencukupi.'
                );
            }
        }

        // ── Generate order_code kalau belum ada ──
        if (!$order->order_code) {
            $order->order_code = 'ORD-' . strtoupper(substr(uniqid(), -6)) . '-' . date('Ymd');
        }

        // ── Hitung total_amount ──
        $order->total_amount = $order->items->sum('subtotal');

        // ── Set address & payment method ──
        $order->address_id      = $request->address_id;
        $order->payment_method  = $request->payment_method; // 'cod' atau 'midtrans'
        $order->note            = $request->note;

        if ($request->payment_method === 'cod') {
            $order->status         = 'pending';
            $order->payment_status = 'unpaid'; // bayar nanti saat COD
        }

        $order->save();

        // ── Kurangi stock produk ──
        foreach ($order->items as $item) {

            if ($item->product) {

                $item->product->decrement('stock', $item->quantity);

            }
        }

        // lanjut redirect / return response...
        // Di akhir method process()
        return redirect()->route('customer.order', ['tab' => 'draf'])
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    public function addressPicker()
    {
        $addresses = Address::where('user_id', auth()->id())
            ->orderByDesc('is_default')
            ->get();

        return view('checkout.address-picker', compact('addresses'));
    }

    public function edit(Address $address)
    {
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
            Address::where('user_id', auth()->id())
                ->where('id', '!=', $address->id)
                ->update(['is_default' => false]);
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

        return redirect()->route('customer.checkout.address-picker')
            ->with('success', 'Alamat berhasil dihapus');
    }
}
