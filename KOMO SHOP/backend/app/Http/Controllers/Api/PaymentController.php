<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller {
    // Mock webhook for payment gateways - update order status based on payload
    public function webhook(Request $request) {
        // Example payload handling for Payme/Click/Stripe
        $data = $request->all();
        // Find order by id contained in payload (depends on gateway)
        $orderId = $data['order_id'] ?? null;
        if (!$orderId) {
            return response()->json(['message'=>'No order_id'],400);
        }
        $order = Order::find($orderId);
        if (!$order) return response()->json(['message'=>'Order not found'],404);
        // Mark paid (in real life validate signature)
        $order->status = 'paid';
        $order->save();
        return response()->json(['message'=>'ok']);
    }
}
