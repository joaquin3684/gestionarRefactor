<?php

namespace App\Repositories;


use App\Climed;
use App\Repositories\Mapper\ClimedMapper;

class ClimedRepo extends Repositorio
{
    public function __construct()
    {
        $this->gateway = new Climed();
        $this->mapper = new ClimedMapper();
    }

    function model()
    {
        return 'App\Repositories\ClimedRepo';
    }

    public function findEspecialidades($id)
    {
        $obj = $this->gateway->with('especialidades')->find($id);
        return $this->mapper->map($obj);
    }

    public function all()
    {
        $obj = $this->gateway->with('especialidades')->get();
        return $this->mapper->map($obj);
    }

    public function findWithObrasSociales($id)
    {
        $obj = $this->gateway->with('obrasSociales')->find($id);
        return $this->mapper->map($obj);
    }
}