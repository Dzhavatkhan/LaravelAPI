<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartPayController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::middleware('auth:web')->group(function() {
    // Route::get('profile', [UserController::class, 'index'])->name('profile');
    // Route::get('cart', [CartPayController::class, 'cart'])->name('cart');
    // Route::get('orders', [CartPayController::class, 'orders'])->name('orders');
    Route::post('registration-process', [AuthController::class, 'registration'])->name("registration");
    Route::post('login-process', [AuthController::class, 'login'])->name("login");
    Route::get("logout", [AuthController::class,"logout"])->name("logout");

    Route::get('addCart', [CartPayController::class, 'addCart'])->name('addCart');
    Route::get("deleteCart", [CartPayController::class, 'deleteCart'])->name('deleteCart');
    Route::get('add order', [CartPayController::class, "addOrder"])->name('addOrder');
    Route::get('json_request_cart', [CartPayController::class, 'json_request_cart'])->name('json-request-cart');
// });

