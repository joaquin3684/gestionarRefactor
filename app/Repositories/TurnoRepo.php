<?php

namespace App\Repositories;


use App\Exceptions\NoTieneAccesoAEstaObraSocialException;
use App\Services\UserFromToken;
use App\Solicitud;
use App\Turno;
use App\Repositories\Mapper\TurnoMapper;

class TurnoRepo extends Repositorio
{
    private $user;
    private $obsUser;
    private $solRepo;
    public function __construct()
    {
        $this->gateway = new Turno();
        $this->mapper = new TurnoMapper();
        $this->solRepo = new SolicitudRepo();
        $service = new UserFromToken();
        $this->user = $service->getUser();
        $this->obsUser = $this->user->obrasSociales->map(function($obraSocial){ return $obraSocial->ID;});

    }

    function model()
    {
        return 'App\Repositories\TurnoRepo';
    }

    public function create(array $data)
    {
        $obs = Solicitud::with('afiliado')->find($data['IDAFILIADO'])->afiliado->IDOBRASOCIAL;
        $obra = $this->obsUser->first(function($obraSocial) use ($obs){
            return $obraSocial == $obs;
        });
        if($obra == null)
        {
            throw new NoTieneAccesoAEstaObraSocialException('acceso denegado');
        } else {
            parent::create($data);
            $this->solRepo->update(['ESTADO' => 'En Espera'], $data['IDSOLICITUD']);
        }
    }

    public function update(array $data, $id)
    {
        $obs = Solicitud::with('afiliado')->find($data['IDAFILIADO'])->afiliado->IDOBRASOCIAL;
        $obra = $this->obsUser->first(function($obraSocial) use ($obs){
            return $obraSocial == $obs;
        });
        if($obra == null)
        {
            throw new NoTieneAccesoAEstaObraSocialException('acceso denegado');
        } else {
            parent::update($data, $id);
        }

    }

    public function find($id)
    {
        $obj = $this->gateway->find($id);
        $solObj = $this->solRepo->find($obj->IDSOLICITUD);
        $obsId = $solObj->getAfiliado()->getObraSocial()->getId();
        $obra = $this->obsUser->first(function($obraSocial) use ($obsId){
            return $obraSocial == $obsId;
        });
        if($obra == null)
        {
            throw new NoTieneAccesoAEstaObraSocialException('acceso denegado');
        } else {
            return $this->mapper->map($obj);
        }
    }


    public function destroy($id)
    {
        $this->find($id);
        return parent::destroy($id);
    }


    public function findBySolicitud($idSolicitud)
    {
        $obj = $this->gateway->where('IDSOLICITUD', $idSolicitud)->where('CONFIRMACION', 0)->firstOrFail();
        return $this->mapper->map($obj);
    }

}