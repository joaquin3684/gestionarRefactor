<?php

namespace App\Http\Controllers;

use App\Afiliado;
use App\Exceptions\UsuarioOPasswordIncorrectosException;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{



    public function hola()
    {
        return 2;
    }


    public function login(Request $request)
    {

        $credentials = $request->only('name', 'password', 'idnotificacion');
        $user = User::with('afiliado')->where('name', $credentials['name'])->firstOrFail();
        if(!Hash::check($credentials['password'], $user->password))
            throw new UsuarioOPasswordIncorrectosException("error");
        $permisos = $user->perfil->pantallas->map(function($pantalla){
            return $pantalla->nombre;
        });

        if($user->afiliado != null) {


            $nombre = $user->afiliado->NOMBRE . ' ' . $user->afiliado->APELLIDO;
            $email = $user->afiliado->EMAIL;

        } else {
            $nombre = 'usuario';
            $email = 'usuario';
        }
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::customClaims(['permisos' => $permisos, 'user_id' => $user->id, 'nombre' => $nombre, 'email' => $email])->fromUser($user)) {
                return response()->json(['success' => false, 'error' => 'We cant find an account with this credentials. Please make sure you entered the right information and you have verified your email address.'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }
        // all good so return the token
        if($credentials['idnotificacion'] != null) {
            $afiliado = Afiliado::find($user->afiliado->ID);
            $afiliado->fill(['IDNOTIF'=>$credentials['idnotificacion']]);
            $afiliado->save();
        }

        return response()->json(['success' => true, 'data'=> [ 'token' => $token ]]);
    }

    public function logout(Request $request)
    {
        $token = JWTAuth::getToken();
        return JWTAuth::decode($token);

    }
}
