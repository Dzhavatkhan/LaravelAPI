<?php

use App\Http\Controllers\Api\CartPayController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AuthController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [CartPayController::class, 'index'])->name('home');
Route::get('auth/registration', function () {
    return view('auth.registration');
})->name('reg-view');
Route::get('auth/login', function () {
    return view('auth.login');
})->name('login-view');
Route::post('api/registration-process', [AuthController::class, 'registration'])->name("registration");
Route::post('api/login-process', [AuthController::class, 'login'])->name("login");


Route::get('{email}/api/profile', [UserController::class, 'index'])->name('profile');

Route::get('{email}/api/orders', [CartPayController::class, 'orders'])->name('orders');
Route::get('{email}/api/add order', [CartPayController::class, "addOrder"])->name('addOrder');

Route::get('{email}/api/cart', [CartPayController::class, 'cart'])->name('cart');
Route::get('{email}/api/add to cart', [CartPayController::class, 'addCart'])->name('addCart');
Route::get("{email}/api/deleteCart", [CartPayController::class, 'deleteCart'])->name('deleteCart');

Route::get('json_request_cart', [CartPayController::class, 'json_request_cart'])->name('json-request-cart');
