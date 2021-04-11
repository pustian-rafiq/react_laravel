<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Auth;
use DB;
use App\User;
use App\Http\Controllers\Exception;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    //check login
    public function login(Request $request){
        try{
              if(Auth::attempt($request->only('email','password'))){
                $user = Auth::user();
                $token = $user->createToken('app')->accessToken;
                return response([
                    'message' =>  "Successfully login",
                    'token' => $token,
                    'user' => $user
                ], 400);
            }
        }catch(Exception $e) {
            //throw $th;
            return response([
                'message' => $e->getMessage()
            ], 400);
        }

        return response([
            'message' => "Invalid Email or Password"
        ], 401);
    }


    //check register
    public function register(RegisterRequest $request){
        
        try{

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ],400);
            $token = $user->createToken('app')->accessToken;

            return response([
                'message' => 'Successfully registered',
                'token' => $token,
                'user' => $user
            ], 400);
        }catch(Exception $e){
            return response([
                'message' => $e->getMessage
            ], 401);
        }
    }
}
