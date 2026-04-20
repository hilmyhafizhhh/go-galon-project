<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $order = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->where('status', 'draft')
            ->first();

        return view('customer.cart.index', compact('order'));
    }
    

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $userId = Auth::id();

        // 1. cari cart (draft)
        $order = Order::where('user_id', $userId)
            ->where('status', 'draft')
            ->first();

        // 2. kalau belum ada → buat
        if (!$order) {
            $order = Order::create([
                'id' => Str::uuid(),
                'user_id' => $userId,
                'status' => 'draft'
            ]);
        }

        // 3. cek item sudah ada?
        $item = OrderItem::where('order_id', $order->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($item) {
            $item->quantity += $request->quantity;
            $item->subtotal = $item->quantity * $item->unit_price;
            $item->save();
        }else {
            // insert baru
            $product = Product::findOrFail($request->product_id);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'unit_price' => $product->price,
                'subtotal' => $product->price * $request->quantity,
            ]);
        }

        return response()->json(['success' => true]);
    }
}
