<?php

namespace App\Repositories;


use App\Farmacia;
use App\Repositories\Mapper\FarmaciaMapper;

class FarmaciaRepo extends Repositorio
{
    public function __construct()
    {
        $this->gateway = new Farmacia();
        $this->mapper = new FarmaciaMapper();
    }

    function model()
    {
        return 'App\Repositories\FarmaciaRepo';
    }

}