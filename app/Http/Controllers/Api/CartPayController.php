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
        $user_id = $request->product_id;
        $carts = DB::select("SELECT products.* FROM products LEFT JOIN carts ON products.id = carts.product_id");
        $cart_count = DB::table('products')->leftJoin('carts', 'products.id', '=', 'carts.product_id')->count(); 

        return view('ajax_blade.profile.cart', compact('carts', 'cart_count', 'user_id'));
        ;
        //->with(response()->json("lalo"))
        
    }
    public function orders()
    {

        //->with(response()->json("lalo"))
        
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
