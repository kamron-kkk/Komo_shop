<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller {
    public function index(Request $request) {
        $query = Product::query()->where('status', true);
        if ($request->filled('q')) { $query->where('name','like','%'.$request->q.'%'); }
        if ($request->filled('category')) { $query->where('category_id',$request->category); }
        $products = $query->with('images')->orderBy('created_at','desc')->paginate(12);
        return response()->json($products);
    }
    public function show($slug) {
        $product = Product::where('slug',$slug)->with(['images','variants'])->firstOrFail();
        return response()->json($product);
    }
}
