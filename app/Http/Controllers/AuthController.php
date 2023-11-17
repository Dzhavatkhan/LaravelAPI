<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function registration(Request $request){
        $data = $request->all([
            "email",
            "name",
            "password"
        ]);
        $user = User::create([
            "email" => $data['email'],
            "name" => $data['name'],
            "password" => bcrypt($data['password']) 
        ]);
        if ($user) {
            auth('web')->login($user);
            $token = $user->createToken("user")->plainTextToken;
            return redirect()->route('profile', Auth::user()->email);
        }

    }
    public function login(Request $request){
        $data = $request->all([
            "email",
            "password"
        ]);
        if (auth('web')->attempt($data)) {
            return redirect(route('profile', Auth::user()->email, Auth::user()->id));
        }
        elseif (auth('admin')->attempt($data)) {
            return redirect(route('admin-panel'));
        }
        else{
            dd(auth('web')->attempt($data),auth('admin')->attempt($data), $data, bcrypt("password"));
        }
    }
}
