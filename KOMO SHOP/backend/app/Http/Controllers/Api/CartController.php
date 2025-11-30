<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller {
    // Retrieves cart by user or session
    public function index(Request $request) {
        $cart = $this->getCart($request);
        $cart->load('items.product.images');
        return response()->json($cart);
    }
    public function add(Request $request) {
        $data = $request->validate([
            'product_id'=>'required|integer',
            'variant_id'=>'nullable|integer',
            'qty'=>'integer|min:1'
        ]);
        $product = Product::findOrFail($data['product_id']);
        $cart = $this->getCart($request);
        $price = $product->price;
        $item = $cart->items()->create([
            'product_id'=>$product->id,
            'variant_id'=>$data['variant_id'] ?? null,
            'qty'=>$data['qty'] ?? 1,
            'price'=>$price
        ]);
        return response()->json($item, 201);
    }
    public function updateItem(Request $request, $id) {
        $item = CartItem::findOrFail($id);
        $data = $request->validate(['qty'=>'required|integer|min:0']);
        if ($data['qty']==0) { $item->delete(); return response()->json(null,204); }
        $item->update(['qty'=>$data['qty']]);
        return response()->json($item);
    }
    protected function getCart(Request $request) {
        if ($request->user()) {
            $cart = Cart::firstOrCreate(['user_id'=>$request->user()->id]);
        } else {
            $session = $request->session()->getId();
            $cart = Cart::firstOrCreate(['session_id'=>$session]);
        }
        return $cart;
    }
}
