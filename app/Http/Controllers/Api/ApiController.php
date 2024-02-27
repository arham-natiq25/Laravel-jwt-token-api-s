<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiController extends Controller
{


    /**  REGISTER */

   public function register(Request $request){
    // validate user
    $request->validate([
        'name'=>'required',
        'email'=>'required|email|unique:users,email',
        'password'=>'required|confirmed',
    ]);
    // save user
    User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>Hash::make($request->password)
    ]);
    // response
    return response()->json([
        'status'=>true,
        'message'=>"User created Successfully"
    ]);
   }



   /**  LOGIN */

   public function login(Request $request){
    //  validation
    $request->validate([
        'email'=>'required',
        'password'=>'required',
    ]);

    // jwt auth and attempt

        $token = JWTAuth::attempt([
            'email'=>$request->email,
            'password'=>$request->password
        ]);

    // response ...
    if (!empty($token)) {

    return response()->json([
        'status'=>true,
        'message'=>"User logged in Successfully",
        'token'=>$token
    ]);
    }
    return response()->json([
        'status'=>false,
        'message'=>"Invalid Credentials"
    ]);

   }

   // PROFILE API .. GET LOGIN USER PROFILE
   public function profile(){
    $userData = auth()->user();
    return response()->json([
        'status'=>true,
        'message'=>'profile data',
        'user'=>$userData
    ]);
   }

   // CREATE NEW TOKEN OF LOGIN USER --
   public function refreshToken(){

    $newToken = auth()->refresh();

    return response()->json([
        'status'=>true,
        'message'=>'New Access Token generated',
        'token'=>$newToken
    ]);


}
public function logout(){

    auth()->logout();
    return response()->json([
        'status'=>true,
        'message'=>'Logout successfully',
    ]);



   }

}
