<?php

namespace App\Repositories;

use App\Afiliado;
use App\Exceptions\NoTieneAccesoAEstaObraSocialException;
use App\Services\UserFromToken;
use App\Solicitud;
use App\Repositories\Mapper\SolicitudMapper;
use App\User;
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

    public function abrir($id)
    {
        $obs = Solicitud::with('afiliado')->find($id)->afiliado->IDOBRASOCIAL;

        $obra = $this->obsUser->first(function($obraSocial) use ($obs){
            return $obraSocial == $obs;
        });
        if($obra == null)
        {
            throw new NoTieneAccesoAEstaObraSocialException('acceso denegado');
        } else {
            $data['ASIGNADO'] = $this->user->id;
            $solicitud = parent::update($data, $id);
            return User::whereHas('obrasSociales', function($q) use ($obs){
                $q->where('id_obra_social', $obs);
            })->where('id_perfil', '<>', '2')->get()->map(function($us){return $us->id;});
        }
    }

    public function create(array $data)
    {
        $afiliado = Afiliado::where('DNI', $data['DNISOLICITANTE'])->get()->first();
        $obra = $this->obsUser->first(function($obraSocial) use ($afiliado){
            return $obraSocial == $afiliado->IDOBRASOCIAL;
        });
        if($obra == null)
        {
            throw new NoTieneAccesoAEstaObraSocialException('acceso denegado');
        } else {
            $data['ESTADO'] = 'Pendiente';
            $data['FECHAS'] = Carbon::today()->toDateString();
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
        $obj = $this->gateway->with('turnos', 'climed', 'afiliado.obraSocial', 'especialidad')
            ->whereHas('afiliado.obraSocial', function($query){
            $query->whereIn('ID', $this->obsUser->toArray());
        })->findOrFail($id);
        return $this->mapper->map($obj);
    }

    public function all()
    {
        $obj = $this->gateway->with('turnos', 'climed', 'afiliado.obraSocial', 'especialidad')
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
        $obj = $this->gateway->with('turnos')
            ->whereHas('afiliado.obraSocial', function($query){
                $query->whereIn('ID', $this->obsUser->toArray());
            })->findOrFail($id);
        return $this->mapper->map($obj);
    }

    public function solicitudesEnProceso()
    {
        $obj = $this->gateway->with(['turnos', 'climed', 'especialidad', 'afiliado' => function($q){
            $q->with('obraSocial')
                ->with('familiares');
        }])
            ->whereHas('afiliado', function($query){
                $query->whereIn('IDOBRASOCIAL', $this->obsUser->toArray());
            })
            ->where(function ($query){
                $query->where('ESTADO', '<>','Confirmado')
                    ->where('ESTADO', '<>', 'Rechazado')
                    ->where('TIPO', '1');
            })

            ->orWhere(function ($query) {
                $query->where('ESTADO', '<>','Confirmado')
                    ->where('ESTADO', '<>', 'Rechazado')
                    ->where('REVISADO', '1')
                    ->where(function ($q){
                        $q->where('ASIGNADO', null)
                            ->orWhere('ASIGNADO', $this->user->id);

                    });
            })->get();
        return $this->mapper->map($obj);
    }

    public function solicitudesParaAuditar()
    {
        $obj = $this->gateway->with(['turnos', 'climed', 'especialidad', 'afiliado' => function($q){
            $q->with('obraSocial')
            ->with('familiares');
        }])
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

    public function historialAuditoria()
    {
        $obj = $this->gateway->with(['climed', 'especialidad', 'afiliado' => function($q){
            $q->with('obraSocial')
                ->with('familiares');
        }])
            ->whereHas('afiliado', function($query){
                $query->whereIn('IDOBRASOCIAL', $this->obsUser->toArray());
            })
            ->where('TIPO', '<>', 1)
            ->where('REVISADO', '<>', 0)
            ->get();
        return $this->mapper->map($obj);
    }

    public function historialCompleto()
    {
        $obj = $this->gateway->with(['turnos', 'climed', 'especialidad', 'afiliado' => function($q){
            $q->with('obraSocial')
                ->with('familiares');
        }])
            ->whereHas('afiliado', function($query){
                $query->whereIn('IDOBRASOCIAL', $this->obsUser->toArray());
            })
            ->get();
        return $this->mapper->map($obj);
    }
}