<?php

namespace App\Repositories;

use App\Afiliado;
use App\Exceptions\NoTieneAccesoAEstaObraSocialException;
use App\Services\UserFromToken;
use App\Solicitud;
use App\Repositories\Mapper\SolicitudMapper;
use Carbon\Carbon;

class SolicitudRepo extends Repositorio
{
    private $user;
    private $obsUser;
    public function __construct()
    {
        $this->gateway = new Solicitud();
        $this->mapper = new SolicitudMapper();
        $service = new UserFromToken();
        $this->user = $service->getUser();
        $this->obsUser = $this->user->obrasSociales->map(function($obraSocial){ return $obraSocial->ID;});

    }

    function model()
    {
        return 'App\Repositories\SolicitudRepo';
    }
    public function create(array $data)
    {
        $afiliado = Afiliado::find($data['IDAFILIADO']);
        $obra = $this->obsUser->first(function($obraSocial) use ($afiliado){
            return $obraSocial == $afiliado->IDOBRASOCIAL;
        });
        if($obra == null)
        {
            throw new NoTieneAccesoAEstaObraSocialException('acceso denegado');
        } else {
            $solicitud = parent::create($data);
            return $solicitud;
        }
    }

    public function update(array $data, $id)
    {
        $data['FECHAMODIFICACION'] = Carbon::today()->toDateString();

        $obs = Solicitud::with('afiliado')->find($id)->afiliado->IDOBRASOCIAL;

        $obra = $this->obsUser->first(function($obraSocial) use ($obs){
            return $obraSocial == $obs;
        });
        if($obra == null)
        {
            throw new NoTieneAccesoAEstaObraSocialException('acceso denegado');
        } else {
            $solicitud = parent::update($data, $id);
            return $solicitud;
        }

    }

    public function find($id)
    {
        $obj = $this->gateway->with('turnos.climed', 'climed', 'afiliado.obraSocial', 'especialidad')
            ->whereHas('afiliado.obraSocial', function($query){
            $query->whereIn('ID', $this->obsUser->toArray());
        })->findOrFail($id);
        return $this->mapper->map($obj);
    }

    public function all()
    {
        $obj = $this->gateway->with('turnos.climed', 'climed', 'afiliado.obraSocial', 'especialidad')
            ->whereHas('afiliado.obraSocial', function($query){
                $query->whereIn('ID', $this->obsUser->toArray());
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

    public function findTurnos($id)
    {
        $obj = $this->gateway->with('turnos.climed')
            ->whereHas('afiliado.obraSocial', function($query){
                $query->whereIn('ID', $this->obsUser->toArray());
            })->findOrFail($id);
        return $this->mapper->map($obj);
    }

    public function solicitudesEnProceso()
    {
        $obj = $this->gateway->with('turnos.climed', 'climed', 'afiliado.obraSocial', 'especialidad')
            ->whereHas('afiliado', function($query){
                $query->whereIn('IDOBRASOCIAL', $this->obsUser->toArray());
            })
            ->where('ESTADO', '<>','Confirmado')
            ->where('ESTADO', '<>', 'Rechazado')
            ->where('TIPO', '1')
            ->orWhere(function ($query) {
                $query->where('ESTADO', '<>','Confirmado')
                    ->where('ESTADO', '<>', 'Rechazado')
                    ->where('REVISADO', '1');
            })->get();
        return $this->mapper->map($obj);
    }

    public function solicitudesParaAuditar()
    {
        $obj = $this->gateway->with('turnos.climed', 'climed', 'afiliado.obraSocial', 'especialidad')
            ->whereHas('afiliado', function($query){
                $query->whereIn('IDOBRASOCIAL', $this->obsUser->toArray());
            })
            ->where('ESTADO', '<>','Confirmado')
            ->where('ESTADO', '<>', 'Rechazado')
            ->where('TIPO', '<>', 1)
            ->where('REVISADO', 0)
            ->get();
        return $this->mapper->map($obj);
    }
}