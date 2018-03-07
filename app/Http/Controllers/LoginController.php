<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class LoginController extends Controller
{

    public function __construct(UserRepo $repo)
    {
        $this->repo = $repo;
    }

    public function login(Request $request)
    {
        $credentials = $request->only('name', 'password');
        $user = $this->repo->findByCredentials($credentials);
        $permisos = $user->getAllPermissions()->map(function($permiso){
            return $permiso->name;
        });
        $token = JWTAuth::customClaims(['foo' => $permisos])->fromUser($user);

        return $token;
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials, $customClaims)) {
                return response()->json(['success' => false, 'error' => 'We cant find an account with this credentials. Please make sure you entered the right information and you have verified your email address.'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }
        // all good so return the token
        return response()->json(['success' => true, 'data'=> [ 'token' => $token ]]);
    }

    public function logout(Request $request)
    {
        $token = JWTAuth::getToken();
        return JWTAuth::decode($token);

    }
}
