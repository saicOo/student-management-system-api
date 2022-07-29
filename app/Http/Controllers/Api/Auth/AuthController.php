<?php

namespace App\Http\Controllers\Api\Auth;

use App\Student;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register(Request $request){
        $fileds =$request->validate([
            "name"=>"required|min:2|max:20|string",
            "email"=>"required|min:2|max:30|string|unique:students,email",
            "password"=>"required|min:8|max:20|string|confirmed",
            "phone"=>"required|digits:11",
            "address"=>"required|string|min:4|max:200",
            "college"=>"required|string|min:3|max:50",

        ]);
        $Student = Student::create([
            'name' =>$fileds['name'],
            'email' =>$fileds['email'],
            'phone' =>$fileds['phone'],
            'address' =>$fileds['address'],
            'college' =>$fileds['college'],
            'password' =>bcrypt($fileds['password'])
        ]);
        $token = $Student->createToken("myapptoken")->plainTextToken;
        $response =[
        "Student"=>$Student,
        "token"=>$token
        ];
        return response($response,201);
            }

            public function login(Request $request){
                $fileds =$request->validate([
                    "email"=>"required|string",
                    "password"=>"required|string",
                ]);

                $Student = Student::where('email',$fileds['email'])->first();
                if(!$Student || !Hash::check($fileds['password'] , $Student->password ) ){
                    return response([
                        "message"=>"Bad login"
                    ],401);
                }
             return   $token =$Student->createToken("myapptoken")->plainTextToken;
                $response =[
                    "Student"=>$Student,
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

            if(auth()->user()->id == $id){
                $Student = Student::findOrFail($id);
               return $response =[
                    "Student"=>$Student,
                    ];
            }else{
                return response()->json([
                    'message' => 'You are not authorized',
                ]);
            }
        }
}
