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

    public function findWithObraSocial($id)
    {
        $obj = $this->gateway->with('obraSocial')->findOrFail($id);
        return $this->mapper->map($obj);
    }

    public function all()
    {
        $obj = $this->gateway->with('obraSocial')->get();
        return $obj->map(function($ob){
            return $this->mapper->map($ob);
        });
    }
}