<?php

namespace App\Repositories;


use App\Solicitud;
use App\Repositories\Mapper\SolicitudMapper;

class SolicitudRepo extends Repositorio
{
    public function __construct()
    {
        $this->gateway = new Solicitud();
        $this->mapper = new SolicitudMapper();
    }

    function model()
    {
        return 'App\Repositories\SolicitudRepo';
    }

    public function all()
    {
        $obj = $this->gateway->with('turnos', 'climed', 'afiliado', 'especialidad')->get();
        return $this->mapper->map($obj);
    }

    public function findTurnos($id)
    {
        $obj = $this->gateway->with('turnos')->find($id);
        return $this->mapper->map($obj);
    }

}