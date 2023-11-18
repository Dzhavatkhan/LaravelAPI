<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            $token = $user->createToken("user")->plainTextToken;
            auth('web')->login($user);
            return redirect()->route('profile', Auth::user()->email);
        }

    }
    public function login(Request $request){
        $data = $request->all([
            "email",
            "password"
        ]);

        $password = bcrypt($data['password']);
        $user = User::where("email", $data['email'])->first();
        if (!$user || Hash::check($password, $user->password)) {
            return response()->json([
                "login" => [
                    "status" => 403,
                    "message" => "Bad creds"
                ]
            ]);
        }
        else{
            return redirect(route('profile', $user->email));

        }
        }

    // public function logout(){
    //     auth()->user()->tokens()->delete();

    //     return response()->json([
    //         "status" => 200,
    //         "message" => "logged out"
    //     ], 200);
    // }
}
