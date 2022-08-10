<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Usercontroller extends Controller
{
    // ------------REGISTRARSE----------------------
    public function register(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed'
        ]);

        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=hash::make($request->password);

        $user->save();

        return response()->json([
            "status"=>1,
            "msg"=>"¡Registro de usuario Exitoso",
        ]);
    }

    // ----------------LOGIN -------------------------
    public function login(Request $request){
        $request->validate([
            "email"=>"required|email",
            "password"=>"required"
        ]);
        $user = User::where("email","=",$request->email)->first();
        
        if(isset($user->id)){
            if(hash::check($request->password, $user->password)){
                $token = $user->createToken("auth_token")->plainTextToken;
                return response()->json([
                    "status"=>1,
                    "msg"=>"¡Usuario logueado Exitosamente",
                    "access_token"=>$token
                ]);
            }else{
                return response()->json([
                    "status"=>0,
                    "msg"=>"¡la password es incorrecta",
                ]);
            }
        }else{
            return response()->json([
                "status"=>0,
                "msg"=>"¡Usuario no registrado",
            ],404);
        }
        
    }


    // ----------------VER DATOS------------------------

    public function userProfile(){
        return response()->json([
            "status" => 0,
            "msg" => "¡Antecedentes del perfil de usuario",
            "data" => auth()->user()
        ]);
        
    }

    // ---------------CERRAR LA SESION-----------------
    public function Logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            "status" => 1,
            "msg" => "¡Cierre Sesion ",
        ]);
    }
}
