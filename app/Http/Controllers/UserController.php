<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login',"register"]]);
    }

    public function register(Request $request){
        $user = new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->location=$request->location;
        $user->password=Hash::make($request->password);
        $res=$user->save();
        if($res){
            return response()->json([
                'message'=>"user registered sucessfully",
                "user"=>$user
            ]);
        }else{
            return response()->json([
                'message'=>"Regestration Failed", 
                "user"=>"none" 
            ]);
        } 
    }
    public function login(Request $request){
        $validator=Validator::make($request->all(),[
            "name"=>"required|string|min:2|max:100",
            "password"=>"required|max:100",
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        } 
        if(!$token =$this->guard()->attempt($validator->validated())){
            return response()->json([
                'message'=>"unauthorized",
                'code'=>4001,   
            ]);
        }
        return $this->responseWithToken($token);
    }

    protected function responseWithToken($token){
        return response()->json([
            'access_token'=> $token,
            'message'=>"authorized",
            'code'=>4000,
        ]);
    }
    public function me()
    {
        return response()->json($this->guard()->user());
    }
    public function guard()
    {
        return Auth::guard();
    }
}
