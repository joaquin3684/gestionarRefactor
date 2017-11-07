<?php

namespace App\Repositories;


use App\Turno;
use App\Repositories\Mapper\TurnoMapper;

class TurnoRepo extends Repositorio
{
    public function __construct()
    {
        $this->gateway = new Turno();
        $this->mapper = new TurnoMapper();
    }

    function model()
    {
        return 'App\Repositories\TurnoRepo';
    }

}