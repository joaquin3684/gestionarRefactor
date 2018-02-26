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
        $obj = $this->gateway->with('especialidades')->findOrFail($id);
        return $this->mapper->map($obj);
    }

    public function all()
    {
        $obj = $this->gateway->with('especialidades')->get();
        return $this->mapper->map($obj);
    }

    public function find($id)
    {
        $obj = $this->gateway->with('obrasSociales', 'especialidades')->findOrFail($id);
        return $this->mapper->map($obj);
    }

    public function findClinicasByEspecialidad($id)
    {
        $obj = $this->gateway->whereHas('especialidades', function($query) use ($id){
            $query->where('IDESPECIALIDAD', $id);
        })->with('especialidades')->orderBy('LOCALIDAD', 'asc')->get();//TODO ordenar por localidad
        return $this->mapper->map($obj);
    }


}