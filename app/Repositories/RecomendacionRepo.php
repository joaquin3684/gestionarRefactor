<?php

namespace App\Repositories;


use App\Afiliado;
use App\Exceptions\NoTieneAccesoAEstaObraSocialException;
use App\Recomendacion;
use App\Repositories\Mapper\RecomendacionMapper;
use App\Services\UserFromToken;

class RecomendacionRepo extends Repositorio
{

    private $user;
    private $obsUser;

    public function __construct()
    {
        $this->gateway = new Recomendacion();
        $this->mapper = new RecomendacionMapper();
        $service = new UserFromToken();
        $this->user = $service->getUser();
        $this->obsUser = $this->user->obrasSociales->map(function($obraSocial){ return $obraSocial->ID;});

    }

    function model()
    {
        return 'App\Repositories\RecomendacionRepo';
    }

    public function create(array $data)
    {
        $afiliado = Afiliado::where('DNI', $data['NRO'])->firstOrFail();
        $obs = $afiliado->IDOBRASOCIAL;
        $obra = $this->obsUser->first(function($obraSocial) use ($obs){
            return $obraSocial == $obs;
        });
        if($obra == null)
        {
            throw new NoTieneAccesoAEstaObraSocialException('acceso denegado');
        } else {

            $recomendacion = $this->gateway->create($data);
            return $recomendacion;

        }
    }

    public function all()
    {
        $obj = $this->gateway->whereHas('afiliado', function($query){
                $query->whereIn('IDOBRASOCIAL', $this->obsUser->toArray());
            })->get();
        return $this->mapper->map($obj);
    }

    public function recomendacionesSinContactar()
    {
        $obj = $this->gateway->whereHas('afiliado', function($query){
            $query->whereIn('IDOBRASOCIAL', $this->obsUser->toArray());
        })->where('CONTACTADO', 0)->get();
        return $this->mapper->map($obj);
    }

    public function update(array $data, $id)
    {
        $recomendacion = Recomendacion::find($id);
        $afiliado = Afiliado::where('DNI', $recomendacion->NRO)->firstOrFail();
        $obs = $afiliado->IDOBRASOCIAL;
        $obra = $this->obsUser->first(function($obraSocial) use ($obs){
            return $obraSocial == $obs;
        });
        if($obra == null)
        {
            throw new NoTieneAccesoAEstaObraSocialException('acceso denegado');
        } else {

            $recomendacion = $this->gateway->update($data, $id);
            return $recomendacion;

        }
    }

}