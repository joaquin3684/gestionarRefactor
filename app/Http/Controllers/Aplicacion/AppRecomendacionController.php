<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 04/04/18
 * Time: 19:19
 */

namespace App\Http\Controllers\Aplicacion;


use App\Http\Controllers\Controller;
use App\Recomendacion;
use App\Repositories\RecomendacionRepo;
use App\Repositories\UserRepo;
use App\Services\UserFromToken;
use Illuminate\Http\Request;

class AppRecomendacionController extends Controller
{
    private $userRepo;
    private $obsUser;
    private $user;
    public function __construct()
    {
        $service = new UserFromToken();
        $this->userRepo = new UserRepo();
        $this->user = $service->getUser();
        $this->obsUser = $this->user->obrasSociales->map(function($obraSocial){ return $obraSocial->ID;});
    }


    public function create(Request $request)
    {
        $repo = new RecomendacionRepo();
        $repo->create($request->all());
    }
}