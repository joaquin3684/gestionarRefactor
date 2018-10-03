<?php

namespace App\Repositories;


use App\Exceptions\NoTieneAccesoAEstaObraSocialException;
use App\Services\UserFromToken;
use App\Solicitud;
use App\Turno;
use App\Repositories\Mapper\TurnoMapper;
use Carbon\Carbon;
use GuzzleHttp\Client;

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
        $data['FECHACREACION'] = Carbon::today()->toDateString();
        $obs = Solicitud::with('afiliado', 'climed')->find($data['IDSOLICITUD']);
        $obs = $obs->afiliado->IDOBRASOCIAL;
        $obra = $this->obsUser->first(function($obraSocial) use ($obs){
            return $obraSocial == $obs;
        });
        if($obra == null)
        {
            throw new NoTieneAccesoAEstaObraSocialException('acceso denegado');
        } else {
           $turno = $this->gateway->create($data);
            $this->solRepo->update(['ESTADO' => 'En Espera'], $data['IDSOLICITUD']);
            $client = new Client();

            $json = ['afiliado' => $obs->afiliado->NOMBRE. ' '. $obs->afiliado->APELLIDO, 'dni' => $obs->afiliado->DNI, 'mail' => $obs->afiliado->EMAIL, 'hora' => $turno->HORAT, 'fecha' => $turno->FECHAT, 'clinica' =>  $obs->climed->NOMBRE, 'domicilio' => $obs->climed->DIRECCION];
            $r = $client->post( 'https://node-gestionar.herokuapp.com/actualizarClientes', ['json' => $json, 'allow_redirects' => false]);
            return $turno;
        }


    }

    public function update(array $data, $id)
    {
        $obs = Solicitud::with('afiliado')->find($data['IDSOLICITUD'])->afiliado->IDOBRASOCIAL;
        $obra = $this->obsUser->first(function($obraSocial) use ($obs){
            return $obraSocial == $obs;
        });
        if($obra == null)
        {
            throw new NoTieneAccesoAEstaObraSocialException('acceso denegado');
        } else {
           $turno = parent::update($data, $id);
           return $turno;
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