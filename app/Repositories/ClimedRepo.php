<?php

namespace App\Repositories;


use App\Climed;
use App\Exceptions\NoTieneAccesoAEstaObraSocialException;
use App\Repositories\Mapper\ClimedMapper;
use App\Services\UserFromToken;

class ClimedRepo extends Repositorio
{
    private $user;
    private $obsUser;
    public function __construct()
    {
        $this->gateway = new Climed();
        $this->mapper = new ClimedMapper();
        $service = new UserFromToken();
        $this->user = $service->getUser();
        $this->obsUser = $this->user->obrasSociales->map(function($obraSocial){ return $obraSocial->ID;});

    }

    function model()
    {
        return 'App\Repositories\ClimedRepo';
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
        $clinica = parent::create($data);
        parent::attach($data['obrasSociales'], 'obrasSociales', $clinica->getId());
        parent::attach($data['especialidades'], 'especialidades', $clinica->getId());

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
        $clinica = parent::update($data, $id);
        parent::detach('obrasSociales', $id);
        parent::attach($data['obrasSociales'], 'obrasSociales', $clinica->getId());
        parent::detach('especialidades', $id);
        parent::attach($data['especialidades'], 'especialidades', $id);

    }

    public function find($id)
    {
        $obj = $this->gateway->with('obrasSociales', 'especialidades')->whereHas('obrasSociales', function($query){
            $query->whereIn('IDOBRASOCIAL', $this->obsUser->toArray());
        })->findOrFail($id);
        return $this->mapper->map($obj);
    }

    public function all()
    {
        $obj = $this->gateway->with('obrasSociales', 'especialidades')
            ->whereHas('obrasSociales', function($query){
                $query->whereIn('IDOBRASOCIAL', $this->obsUser->toArray());
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

    public function findClinicasByEspecialidad($id)
    {
        $obj = $this->gateway->whereHas('especialidades', function($query) use ($id){
            $query->where('IDESPECIALIDAD', $id);//TODO aca falta el chequeo de obras sociales
        })->with('especialidades')->orderBy('LOCALIDAD', 'asc')->get();//TODO ordenar por localidad
        return $this->mapper->map($obj);
    }


}