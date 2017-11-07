<?php

namespace App\Repositories;


use App\Recomendacion;
use App\Repositories\Mapper\RecomendacionMapper;

class RecomendacionRepo extends Repositorio
{
    public function __construct()
    {
        $this->gateway = new Recomendacion();
        $this->mapper = new RecomendacionMapper();
    }

    function model()
    {
        return 'App\Repositories\RecomendacionRepo';
    }

}