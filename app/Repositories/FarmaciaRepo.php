<?php

namespace App\Repositories;


use App\Exceptions\NoTieneAccesoAEstaObraSocialException;
use App\Farmacia;
use App\Repositories\Mapper\FarmaciaMapper;
use App\Services\UserFromToken;

class FarmaciaRepo extends Repositorio
{
    private $user;
    private $obsUser;

    public function __construct()
    {
        $this->gateway = new Farmacia();
        $this->mapper = new FarmaciaMapper();
        $service = new UserFromToken();
        $this->user = $service->getUser();
        $this->obsUser = $this->user->obrasSociales->map(function($obraSocial){ return $obraSocial->ID;});

    }

    function model()
    {
        return 'App\Repositories\FarmaciaRepo';
    }

    public function create(array $data)
    {
        $obrasSociales = $data['obrasSociales'];
        foreach ($obrasSociales as $obs)
        {
            if(!$this->obsUser->contains($obs))
            {
                throw new NoTieneAccesoAEstaObraSocialException('acceso denegado');
            }
        }
        $farmacia = parent::create($data);
        parent::attach($data['obrasSociales'], 'obrasSociales', $farmacia->getId());
        return $farmacia;
    }

    public function update(array $data, $id)
    {
        $obrasSociales = $data['obrasSociales'];
        foreach ($obrasSociales as $obs)
        {
            if(!$this->obsUser->contains($obs))
            {
                throw new NoTieneAccesoAEstaObraSocialException('acceso denegado');
            }
        }
        $farmacia = parent::create($data);
        parent::detach('obrasSociales', $id);
        parent::attach($data['obrasSociales'], 'obrasSociales', $farmacia->getId());
        return $farmacia;

    }

    public function find($id)
    {
        $obj = $this->gateway->with('obrasSociales')->whereHas('obrasSociales', function($query){
            $query->whereIn('id_obra_social', $this->obsUser->toArray());
        })->findOrFail($id);
        return $this->mapper->map($obj);
    }

    public function all()
    {
        $obj = $this->gateway->with('obrasSociales')
            ->whereHas('obrasSociales', function($query){
                $query->whereIn('id_obra_social', $this->obsUser->toArray());
            })->get();
        return $obj->map(function($ob){
            return $this->mapper->map($ob);
        });
    }

    public function destroy($id)
    {
        $this->find($id);
        return parent::destroy($id);
    }



}