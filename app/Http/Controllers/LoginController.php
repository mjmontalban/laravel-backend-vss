<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\ApiKey;
use App\Models\User;
use Carbon\Carbon;
class LoginController extends Controller
{
    public function login(LoginRequest $request) {

        $salt = "VSSAPISALT";
        $payload = $request->validated();
        if(!Auth::attempt($payload)) {
            return response()->json([
                'status' => false,
                'message' => 'Login Failed'
            ]);
        }

        $api_key = hash('sha512', $salt.time());

        $expiration_date = Carbon::now()->addDays(1)->format('Y-m-d');

        $user = Auth::user();

        Auth::login($user);
        
        $apiKey = ApiKey::create([
            "user_id" => $user->id,
            "api_key" => $api_key,
            "expiration_date" => $expiration_date
        ]);


        return response()->json([
            'status' => true,
            'message' => 'LoggedIn Success',
            'key' => $apiKey->api_key
        ]); 
    }


    public function register(Request $request) {

        try {
            User::create([
                "email" => $request->email,
                "password" => $request->password,
                "name" => $request->name
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User created.'
            ]); 
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]); 
        }
    }
}
