<?php

namespace App\Http\Middleware;

use Closure;
use Mockery\Exception;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Tymon\JWTAuth\Facades\JWTAuth;

class Permisos
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = JWTAuth::getToken();
        $permisos = JWTAuth::decode($token)['foo'];
        $path = explode("/", $request->getPathInfo());
        $pantalla = $path[1];
        foreach($permisos as $permiso)
        {
            if($permiso == $pantalla)
            {
                return $next($request);
            }
        }
        throw new MethodNotAllowedException();
    }
}
