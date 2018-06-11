<?php

namespace App\Repositories;


use App\ObraSocial;
use App\Repositories\Mapper\ObraSocialMapper;
use App\Services\UserFromToken;

class ObraSocialRepo extends Repositorio
{

    private $user;
    private $obsUser;
    public function __construct()
    {
        $this->gateway = new ObraSocial();
        $this->mapper = new ObraSocialMapper();
        $service = new UserFromToken();
        $this->user = $service->getUser();
        $this->obsUser = $this->user->obrasSociales->map(function($obraSocial){ return $obraSocial->ID;});

    }

    function model()
    {
        return 'App\Repositories\ObraSocialRepo';
    }

    public function all()
    {
        $obj = $this->gateway->whereIn('ID', $this->obsUser->toArray())
            ->get();
        return $obj->map(function($ob){
            return $this->mapper->map($ob);
        });
    }
}