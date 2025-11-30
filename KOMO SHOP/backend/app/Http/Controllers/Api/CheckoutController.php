<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller {
    public function checkout(Request $request) {
        // Basic guest checkout flow - validation minimal here
        $data = $request->validate([
            'shipping.name'=>'required',
            'shipping.phone'=>'required',
            'shipping.address'=>'required',
            'payment_method'=>'required'
        ]);
        $cart = Cart::with('items')->find($request->cart_id);
        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['message'=>'Cart is empty'], 422);
        }
        DB::beginTransaction();
        try {
            $total = $cart->items->sum(function($i){ return $i->price * $i->qty; });
            $order = Order::create([
                'user_id'=>$request->user()?->id ?? null,
                'total'=>$total,
                'status'=>'pending',
                'payment_method'=>$data['payment_method'],
                'shipping_address'=>json_encode($data['shipping']),
            ]);
            foreach ($cart->items as $i) {
                OrderItem::create([
                    'order_id'=>$order->id,
                    'product_id'=>$i->product_id,
                    'variant_id'=>$i->variant_id,
                    'qty'=>$i->qty,
                    'price'=>$i->price
                ]);
            }
            // Optionally clear cart items
            $cart->items()->delete();
            DB::commit();
            // Return order and a simulated payment link
            return response()->json(['order'=>$order, 'payment_link'=>url('/pay/mock/'.$order->id)], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message'=>'Checkout failed','error'=>$e->getMessage()], 500);
        }
    }
}
