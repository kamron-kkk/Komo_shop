<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PaymentController;

// Public
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{slug}', [ProductController::class, 'show']);

// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Cart
Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/items', [CartController::class, 'add']);
Route::patch('/cart/items/{id}', [CartController::class, 'updateItem']);

// Checkout & orders
Route::post('/checkout', [CheckoutController::class, 'checkout']);
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{id}', [OrderController::class, 'show']);

// Payments webhook
Route::post('/payments/webhook', [PaymentController::class, 'webhook']);
