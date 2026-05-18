<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');
    }

    public function createPayment(Request $request, Order $order)
    {
        // Update address jika dikirim dari frontend
        if ($request->address_id) {
            $order->address_id = $request->address_id;
            $order->save();
        }

        $items = [];
        foreach ($order->items as $item) {
            $items[] = [
                'id'       => $item->product->id,
                'price'    => (int) $item->product->price,
                'quantity' => (int) $item->quantity,
                'name'     => $item->product->name,
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . substr(str_replace('-', '', $order->id), 0, 8) . '-' . time(),
                'gross_amount' => (int) $order->items->sum('subtotal'),
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email'      => auth()->user()->email,
                'phone'      => auth()->user()->phone ?? '-',
            ],
            'item_details' => $items,

            // ── Batasi metode pembayaran ──
            'enabled_payments' => [
                'gopay',
                'qris',
                'bca_va',
                'bri_va',
                'bni_va',
                'mandiri_va',
                'credit_card',
            ],

            // ── Custom tema & nama ──
            'custom_expiry' => [
                'expiry_duration' => 24,
                'unit'            => 'hour',
            ],

            'callbacks' => [
                'finish' => url('/orders'),
            ],

            'snap_token_properties' => [
                'merchant_name' => 'GoGalon',
                'merchant_url'  => url('/'),
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        $order->payment_token  = $snapToken;
        $order->payment_method = 'midtrans';
        $order->save();

        return response()->json(['token' => $snapToken]);
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashedKey = hash(
            'sha512',
            $request->order_id .
                $request->status_code .
                $request->gross_amount .
                $serverKey
        );

        if ($hashedKey !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Format order_id: ORDER-{8char}-{timestamp}
        $parts   = explode('-', $request->order_id);
        $shortId = $parts[1] ?? null;
        $order   = Order::whereRaw('LEFT(REPLACE(id, "-", ""), 8) = ?', [$shortId])->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if (in_array($request->transaction_status, ['capture', 'settlement'])) {
            $order->update([
                'payment_status' => 'paid',
                'transaction_id' => $request->transaction_id,
                'status'         => 'confirmed',
            ]);
        } elseif (in_array($request->transaction_status, ['cancel', 'deny', 'expire'])) {
            $order->update([
                'payment_status' => 'failed',
                'status'         => 'cancelled',
            ]);
        }

        return response()->json(['message' => 'OK']);
    }
}
