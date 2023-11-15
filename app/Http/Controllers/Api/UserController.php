<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();


        return view('auth.profile', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $prdouct_id = $request->product_id;
        $user_id = Auth::user()->id;
        $cart_qu = Cart::query()->where("user_id", $user_id)->where("product_id", $prdouct_id)->first();
        if ($cart_qu->quantity == 0) {
            Cart::create([
                "user_id" =>$user_id,
                "product_id" =>$prdouct_id,
                "quantity" => 1
            ]);
            return response()->json([

            ]);
        }
        else{
            $cart_qu::update(["quantity" => $cart_qu->quantity + 1]);
        }
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
