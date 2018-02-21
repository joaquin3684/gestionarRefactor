<?php

namespace App\Repositories;


use App\Afiliado;
use App\Repositories\Mapper\AfiliadoMapper;

class AfiliadoRepo extends Repositorio
{
    public function __construct()
    {
        $this->gateway = new Afiliado();
        $this->mapper = new AfiliadoMapper();
    }

    function model()
    {
        return 'App\Repositories\AfiliadoRepo';
    }


}