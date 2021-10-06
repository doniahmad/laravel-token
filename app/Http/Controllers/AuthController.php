<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpseclib3\Crypt\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            if (Auth::attempt($request->only('username', 'password'))) {
                /** @var User $user */
                $user = Auth::user();
                $token = $user->createToken('app')->accessToken;

                return response([
                    'message' => 'succes',
                    'token' => $token,
                    'user' => $user
                ]);
            }
            return response([
                'message' => 'invalid username/password'
            ], 401);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function user(){
        return Auth::user();
    }

    public function register(RegisterRequest $request){

        try {
            $user = User::create([
                'username' => $request->input('username'),
                'password' => \Illuminate\Support\Facades\Hash::make($request->input('password')),
            ]);
            return $user;
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage()
            ],400);
        }

    }

}
