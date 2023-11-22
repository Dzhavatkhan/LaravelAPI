<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartPayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $products = Product::all();
        // return view('welcome', compact('products'));
        return response()->json([
            "content" => [
                $products
            ]
            ]);
    }

    public function cart(Request $request)
    {
        // $user = Auth::user();
        $user_id = Auth::user()->id;
        $carts = DB::select("SELECT products.*, carts.quantity, carts.id AS 'cart_id' FROM products LEFT JOIN carts ON products.id = carts.product_id WHERE carts.user_id = $user_id");
        $cart_count = DB::table('products')->leftJoin('carts', 'products.id', '=', 'carts.product_id')->where('user_id', $user_id)->count();
        $sum_price = DB::table('products')->leftJoin('carts', 'products.id', '=', 'carts.product_id')->where('user_id', $user_id)->sum('price');
        // if ($cart_count > 0) {
        //     return response()->json("lalo");
        // }
        // $response = ["response" => "lalo"];
        // return view('ajax_blade.profile.cart', compact('carts', 'sum_price', 'cart_count', 'user_id'));
        return response()->json([
            "content" => [
                 $carts
            ]
            ],201)->header("Content-type", "application/json");


    }
    public function json_request_cart(){
        $user = Auth::user();
        $carts = DB::select("SELECT products.* FROM products LEFT JOIN carts ON products.id = carts.product_id WHERE user_id = $user->id ");
        $cart_count = DB::table('products')->leftJoin('carts', 'products.id', '=', 'carts.product_id')->count();
        if ($cart_count > 0) {
            return response()
            ->json([
                "status" => 200,
                "carts" => $carts
                ])
            ->header('Content-type', 'application/json');
        }
    }

    public function orders(Request $request)
    {

        $user_id = Auth::user()->id;
        $orders = DB::select("SELECT products.*, orders.quantity AS 'quantity', orders.quantity * price AS order_price FROM products LEFT JOIN carts ON products.id = carts.product_id LEFT JOIN orders ON carts.id = orders.cart_id WHERE orders.user_id = $user_id");
        $order_count = DB::table('products')->leftJoin('carts', 'products.id', '=', 'carts.product_id')->leftJoin('orders', 'carts.id', 'orders.cart_id')->where('orders.user_id', $user_id)->count();
        // if ($cart_count > 0) {
        //     return response()->json("lalo");
        // }
        $days = rand(1, 7);
        // $price = DB::select(" SELECT DISTINCT SUM(products.price * orders.quantity) AS 'SUM' FROM products LEFT JOIN carts ON products.id = carts.product_id LEFT JOIN orders ON carts.id = orders.cart_id WHERE orders.user_id = $user_id");
        // return view('ajax_blade.profile.orders', compact('orders', 'days', 'order_count', 'user_id'));
        return response()->json([
            "content" => [
                $orders
            ]
            ],201)->header("Content-type", "application/json");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function addCart(Request $request, $id)
    {
        if (isset($request)) {
            $product_id = $request->id;
        }
            $product_id = $id;
        $product_cart = Cart::all()->where('product_id', $product_id)->where("user_id", Auth::user()->id)->first();
        if ($product_cart == null  || $product_cart->count() == "null") {
            $add = Cart::create([
                "user_id" => Auth::user()->id,
                "product_id" => $product_id,
                "quantity" => 1
            ]);
        }
        else{
            $quantity = $product_cart->quantity + 1;
            $add = $product_cart->update(["quantity" => $quantity]);
        }

        return response()->json([
            "content" => [
                "message" => "Товар в корзине"
            ]
            ],201)->header("Content-type", "application/json");


    }
    public function deleteCart(Request $request){

        $product_id = $request->id;
        $user = Auth::user();
        $cart = Cart::query()->where("id", $product_id)->first();
        if ($cart->quantity == 1) {
            $cart->delete();
        }
        else{
            $quantity = $cart->quantity - 1;
            $upd = Cart::query()->where("id", $product_id)->update(["quantity" => $quantity]);
        }

        return response()->json([
            "content" =>  [
                "message" => "Позиция удалена из корзины"
            ]
            ], 200)->header("Content-type", "application/json");

    }
    public function addOrder(Request $request){
        $cart_id = $request->id;
        $user = Auth::user();
        $order = Order::query()->where("user_id", $user->id)->where("cart_id", $cart_id)->first();
        if ($order == null) {
            $order = Order::create([
                "user_id" => $user->id,
                "cart_id" => $cart_id,
                "quantity" => 1
            ]);
        }
        else{
            $quantity = $order->quantity + 1;
            $order->update(["quantity" => $quantity]);
        }

        return response()->json([
            "content" => [
                "order_id" =>  $order->id,
                "message" => "Заказ оформлен"
            ]
            ],200)->header("Content-type", "application/json");

    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        if (!isset($product)) {
            return response()->json([
                "warning" => [
                    "code" => 404,
                    "message" => "Не найдено"
                ]
                ],404)->header("Content-type", "application/json");
        }
        else{
            return response()->json([
                "content" => [
                    "id" => $product->id,
                    "name" => $product->name,
                    "category" => "$product->category",
                    "price" => $product->price
                ]
                ],200)->header("Content-type", "application/json");
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
