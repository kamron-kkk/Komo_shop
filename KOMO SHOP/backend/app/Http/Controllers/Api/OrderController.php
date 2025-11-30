<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller {
    public function show($id) {
        $order = Order::with('items')->findOrFail($id);
        return response()->json($order);
    }
    public function index(Request $request) {
        $query = Order::query();
        if ($request->user()) { $query->where('user_id',$request->user()->id); }
        return response()->json($query->paginate(15));
    }
}
