<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psy\Util\Str;

class ForgotController extends Controller
{
    public function Forgot(ForgotRequest $request) {

        $username = $request -> input('username');

        if(User::where('username',$username)->doesntExsist()){
            return response([
                'message' => 'User doesn\'t exsist'
            ],404);
        }

        $token = \Illuminate\Support\Str::random(10);

        try {
            DB::table('password_reset')->insert([
                'username' => $username,
                'token' => $token,
            ]);
            return response([
                'message' => 'Check your email',
            ]);
        }catch (\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ],400);
        }
    }
}
