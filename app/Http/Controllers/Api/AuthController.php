<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Dotenv\Validator as DotenvValidator;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

use function Laravel\Prompts\error;

class AuthController extends Controller
{
    public function registration(RegistrationRequest $request){
        try{

        
        $data = $request->validate([
            "email" => ['email', 'required'],
            "name" =>  ['string', 'required'],
            "password" =>  ['string', 'required']
        ]);
    }
    catch (ValidationException $expection) {
        $errors = [];
        foreach ($expection->errors() as $error => $messages) {
            foreach($messages as $message){
                $errors[] = [
                    $err = $message
                ];
            }

        }

        return response()->json([
            "warning" => [
                "message" => "Несоответсвтие требованиям",
                "warnings" => $err
            ]
            ],422)->header("Content-type", "application/json");
    }


        $user = User::create([
            "email" => $data['email'],
            "name" => $data['name'],
            "password" => bcrypt($data['password'])
        ]);
        if ($user) {
            $token = $user->createToken($data["name"])->plainTextToken;
            auth('web')->login($user);
            return response()->json([
                "content" => [
                    "user_token" => $token
                ]
                ],201)->header("Content-type", "application/json");
        }

    }
    public function login(Request $request){
       
       try{
            $data = $request->validate([
                "email" => ['email', 'required'],
                "password" => ['required', 'string']
            ]);
       }
       catch(ValidationException $expection){

        $errors = [];
        foreach ($expection->errors() as $error => $messages) {
            foreach($messages as $message){
                $errors[] = [
                    $err = $message
                ];
            }

        }

        return response()->json([
            "warning" => [
                "message" => "Несоответсвтие требованиям",
                "warnings" => $err
            ]
            ],422)->header("Content-type", "application/json");
    }


        // if (!isset($data['password'])) {
        //     return response()->json([
        //         "warning" => [
        //             "code" => 403,
        //             "message" => "Несоответсвтие требованиям",
        //             "warning" => "Поле пароля пусто"
        //         ]
        //     ], 403)->header("Content-type","application/json");
        // }
        // if (!isset($data['email'])) {
        //     return response()->json([
        //         "warning" => [
        //             "code" => 403,
        //             "message" => "Несоответсвтие требованиям",
        //             "warning" => "Поле почты пусто"
        //         ]
        //     ], 403)->header("Content-type","application/json");
        // }
        // if (!isset($data['email']) && !isset($data['password'])) {
        //     return response()->json([
        //         "warning" => [
        //             "code" => 403,
        //             "message" => "Несоответсвтие требованиям",
        //             "warning" => "Поле почты пусто"
        //         ]
        //     ], 403)->header("Content-type","application/json");
        // }
    


        $password = bcrypt($data['password']);
        // $password = $data['password'];
        $user = User::where("email", $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                "warning" => [
                    "code" => 401,
                    "message" => "Неправильно введены данные или не найден пользователь"
                ]
            ], 401)->header("Conetnt-type","application/json");

        }
        else{
            // dd($data['password'], "1: ", Hash::check($data['password'], $user->password), "2: ", Hash::check($data['password'], bcrypt($user->password)));

            $token = $user->createToken("$user->name")->plainTextToken;
            if (auth('web')->attempt($data)) {
                return response()->json([
                    "content"=> [
                        "token" => $token
                    ]
                ]);
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
