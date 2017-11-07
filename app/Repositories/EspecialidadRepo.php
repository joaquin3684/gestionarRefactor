<?php

namespace App\Repositories;


use App\Especialidad;
use App\Repositories\Mapper\EspecialidadMapper;

class EspecialidadRepo extends Repositorio
{
    public function __construct()
    {
        $this->gateway = new Especialidad();
        $this->mapper = new EspecialidadMapper();
    }

    function model()
    {
        return 'App\Repositories\EspecialidadRepo';
    }

}