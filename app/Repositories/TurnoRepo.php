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

    public function findBySolicitud($idSolicitud)
    {
        $obj = $this->gateway->where('IDSOLICITUD', $idSolicitud)->where('CONFIRMACION', 0)->firstOrFail();
        return $this->mapper->map($obj);
    }

}