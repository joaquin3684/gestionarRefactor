<?php

namespace App\Repositories;


use App\ObraSocial;
use App\Repositories\Mapper\ObraSocialMapper;

class ObraSocialRepo extends Repositorio
{
    public function __construct()
    {
        $this->gateway = new ObraSocial();
        $this->mapper = new ObraSocialMapper();
    }

    function model()
    {
        return 'App\Repositories\ObraSocialRepo';
    }

}