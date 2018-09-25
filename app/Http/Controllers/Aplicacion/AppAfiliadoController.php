<?php

namespace App\Http\Controllers\Aplicacion;

use App\Afiliado;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepo;
use App\Services\UserFromToken;
use Illuminate\Http\Request;

class AppAfiliadoController extends Controller
{
    private $userRepo;
    private $obsUser;
    private $user;
    private $repo;
    public function __construct()
    {
        // $this->obsUser = collect([1,2,3])
        $service = new UserFromToken();
        $this->userRepo = new UserRepo();
        $this->user = $service->getUser();
        $this->obsUser = $this->user->obrasSociales->map(function($obraSocial){ return $obraSocial->ID;});
    }
    public function modificarEmail(Request $request)
    {
        $afiliado = Afiliado::where('DNI', $request['DNI'])->first();
        $afiliado->fill($request->all());
        $afiliado->save();
    }
}
