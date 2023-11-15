<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartPayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function cart(Request $request)
    {
        // $user = Auth::user();
        $user_id = Auth::user()->id;
        $carts = DB::select("SELECT products.* FROM products LEFT JOIN carts ON products.id = carts.product_id WHERE carts.user_id = $user_id");
        $cart_count = DB::table('products')->leftJoin('carts', 'products.id', '=', 'carts.product_id')->where('user_id', $user_id)->count();
        // if ($cart_count > 0) {
        //     return response()->json("lalo");
        // }
        $response = ["response" => "lalo"];
        return view('ajax_blade.profile.cart', compact('carts', 'cart_count', 'user_id'));
        //->with(response()->json("lalo"))

    }
    public function json_request_cart(){
        $carts = DB::select("SELECT products.* FROM products LEFT JOIN carts ON products.id = carts.product_id");
        $cart_count = DB::table('products')->leftJoin('carts', 'products.id', '=', 'carts.product_id')->count();
        if ($cart_count > 0) {
            return response()->json([
                "status" => 200,
                "carts" => $carts
                ])->header('Content-type', 'application/json');
        }
    }
    public function orders(Request $request)
    {

        $user_id = Auth::user()->id;
        $orders = DB::select("SELECT products.* FROM products LEFT JOIN carts ON products.id = carts.product_id LEFT JOIN orders ON carts.id = orders.cart_id WHERE orders.user_id = $user_id");
        $orders_count = DB::table('products')->leftJoin('carts', 'products.id', '=', 'carts.product_id')->leftJoin('orders', 'carts.id', 'orders.cart_id')->where('user_id', $user_id)->count();
        // if ($cart_count > 0) {
        //     return response()->json("lalo");
        // }
        return view('ajax_blade.profile.cart', compact('orders', 'orders_count', 'user_id'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
