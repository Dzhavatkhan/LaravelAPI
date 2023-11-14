<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function registration(){
        return "working";
    }
    public function login(Request $request){
        $data = $request->all([
            "email",
            "password"
        ]);
        if (auth('web')->attempt($data)) {
            dd("user");
            return redirect(route('/'));
        }
        elseif (auth('admin')->attempt($data)) {
            return redirect(route('/'));
        }
        else{
            dd(auth('web')->attempt($data),auth('admin')->attempt($data), $data, bcrypt("password"));
        }
    }
}
