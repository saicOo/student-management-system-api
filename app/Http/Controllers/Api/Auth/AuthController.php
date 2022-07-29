<?php

namespace App\Http\Controllers\Api\Auth;

use App\Admin;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register(Request $request){
        $fileds =$request->validate([
            "name"=>"required|string|min:2|max:20",
            "email"=>"required|string|max:30|unique:admins,email",
            "password"=> ['required','string','min:8','confirmed',
            'regex:/^.*(?=.{3,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#@%]).*$/'],
            "role"=>"required|in:1,2",
        ],[
            'password.regex' => 'The password must contain numbers, uppercase and lowercase letters, and symbols (#$%@!).'
        ]);
        $Admin = Admin::create([
            'name' =>$fileds['name'],
            'email' =>$fileds['email'],
            'role' =>$fileds['role'],
            'password' =>bcrypt($fileds['password'])
        ]);
        $token =$Admin->createToken("myapptoken")->plainTextToken;
        $response =[
        "Admin"=>$Admin,
        "token"=>$token
        ];
        return response($response,201);
            }

            public function login(Request $request){
                $fileds =$request->validate([
                    "email"=>"required|string",
                    "password"=>"required|string",
                ]);
                $Admin = Admin::where('email',$fileds['email'])->first();
                if(!$Admin || !Hash::check($fileds['password'] , $Admin->password ) ){
                    return response([
                        "message"=>"Bad login"
                    ],401);
                }
                $token =$Admin->createToken("myapptoken")->plainTextToken;
            return   $response =[
                    "Admin"=>$Admin,
                    "token"=>$token
                    ];
            }

            public function logout(Request $request){
                auth()->user()->tokens()->delete();
                return [
                    "message"=>"Logged Out"
                ];
            }
            public function show($id){
                $Admin = Admin::findOrFail($id);
                if(auth()->user()->id == $id || auth()->user()->role == 1){
                    return   $response =[
                        "Admin"=>$Admin,
                        ];
                }else{
                    return response()->json([
                        'message' => 'You are not authorized',
                    ]);
                }

            }
            public function destroy($id){
                if(auth()->user()->id != $id){
                    $Admin = Admin::findOrFail($id);
                    $Admin->delete();
                    return response()->json([
                        'message' => 'The admin has been removed',
                    ]);
                }else{
                    return response()->json([
                        'message' => 'The admin cannot be deleted !!!!',
                    ]);
                }
            }
}
