<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function registration(RegistrationRequest $request){
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
            $token = $user->createToken($data["name"])->plainTextToken;
            auth('web')->login($user);
            return redirect()->route('profile', Auth::user()->email);
        }

    }
    public function login(Request $request){
        $data = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required", "string"]
        ]);
        $password = bcrypt($data['password']);
        // $password = $data['password'];
        $user = User::where("email", $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            // return response()->json([
            //     "log in" => [
            //         "status" => 401,
            //         "message" => "Bad creds"
            //     ]
            // ], 401);
            return redirect()->back()->withErrors([
                "email" => "Пользователь не найден, либо данные были введены неверно"
            ]);
        }
        else{
            // dd($data['password'], "1: ", Hash::check($data['password'], $user->password), "2: ", Hash::check($data['password'], bcrypt($user->password)));

            $token = $user->createToken("$user->name")->plainTextToken;
            if (auth('web')->attempt($data)) {
                return redirect(route("profile", $user->email));
            }
            else{

            }

        }
        }

        public function logout(){
            $user = Auth::user();
            $token = PersonalAccessToken::where("name", $user->name)->first()->token;
            PersonalAccessToken::where("name", $user->name)->first()->delete();
            auth('web')->logout();
            return response()->json([
                "status" => 200,
                "message" => "logged out"
            ], 200);
        }
}
