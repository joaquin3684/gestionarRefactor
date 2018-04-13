<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 04/04/18
 * Time: 19:09
 */

namespace App\Http\Controllers\Aplicacion;


use App\Farmacia;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepo;
use App\Services\UserFromToken;

class AppFarmaciaController extends Controller
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

    public function all()
    {
        return Farmacia::whereHas('obrasSociales', function($query){
            $query->whereIn('id_obra_social', $this->obsUser->toArray());
        })->get();
    }


}