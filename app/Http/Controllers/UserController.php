<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login()
    {
        $data= [
            'email'=>request('email'),
            'password'=> request('password')

        ];


        if(Auth::attempt($data))//devuelve un booleano)
        {
            $user=Auth::user();
            $loginData['token']=$user->createToken('SGOtoken')->accessToken;
            $empleado=$user->idEmpleado;
            return response()->json([
                "message"=>"Bienvenido",
                "data"=>$loginData,
                "empleado"=>$empleado

            ], 200);
        }
        else
        {
            return response()->json([
                "message"=>"Error en el login"
            ], 401);

        }
    }

    public function register(Request $request)
    {
        $data= $request->all();
        $data['password']= bcrypt($data['password']);//se encripta la contraseña
        $user= User::create($data);
        $loginData['token']=$user->createToken('SGOtoken')->accessToken;

        return response()->json([
            "message"=>"El usuario ha sido creado",
            "data"=>$loginData,
            //"pass"=> $data //se visualiza los datos del usuario creado

    ], 200);
    }

}
