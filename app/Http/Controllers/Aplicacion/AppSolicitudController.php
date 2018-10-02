<?php

namespace App\Http\Controllers\Aplicacion;

use App\Afiliado;
use App\Familiar;
use App\Http\Controllers\Controller;
use App\Http\Requests\SolicitudValidator;
use App\Repositories\SolicitudRepo;
use App\Repositories\TurnoRepo;
use App\Repositories\UserRepo;
use App\Services\UserFromToken;
use App\Solicitud;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppSolicitudController extends Controller
{

    private $repo;
    private $turnosRepo;
    private $userRepo;
    public function __construct(SolicitudRepo $repo, TurnoRepo $turnosRepo, UserRepo $userRepo)
    {
        $this->repo = $repo;
        $this->turnosRepo  = $turnosRepo;
        $this->userRepo = $userRepo;
    }

    public function storeClinico(SolicitudValidator $request)
    {
        DB::transaction(function() use ($request){
            $rango = $request['rango'];
            $request['TIPO'] = 1;
            $solicitud = $this->repo->create($request->all());
            $client = new Client();
            $obs = Solicitud::with('afiliado')->find($solicitud->getId())->afiliado->IDOBRASOCIAL;
            $usersANotificar = $this->userRepo->usersWithObraSocial($obs)->map(function($user){return $user->id;});
            $r = $client->post( 'https://node-gestionar.herokuapp.com/actualizarClientes', ['json' => $usersANotificar->toArray(), 'allow_redirects' => false]);
            });
    }

    public function storeEspecialidad(SolicitudValidator $request)
    {
        DB::transaction(function() use ($request) {
            $rango = $request['rango'];

            $request['TIPO'] = 2;
            $solicitud = $this->repo->create($request->all());
            $client = new Client();
            $obs = Solicitud::with('afiliado')->find($solicitud->getId())->afiliado->IDOBRASOCIAL;
            $usersANotificar = $this->userRepo->auditoresWithObraSocial($obs)->map(function($user){return $user->id;});
            $r = $client->post( 'https://node-gestionar.herokuapp.com/actualizarClientes', ['json' => $usersANotificar->toArray(), 'allow_redirects' => false]);

        });
    }

    public function storeEstudio(Request $request)
    {
        DB::transaction(function() use ($request) {
            $rango = $request['rango'];

            $request['TIPO'] = 3;
            $solicitud = $this->repo->create($request->all());
            $client = new Client();
            $obs = Solicitud::with('afiliado')->find($solicitud->getId())->afiliado->IDOBRASOCIAL;
            $usersANotificar = $this->userRepo->auditoresWithObraSocial($obs)->map(function($user){return $user->id;});
            $r = $client->post( 'https://node-gestionar.herokuapp.com/actualizarClientes', ['json' => $usersANotificar->toArray(), 'allow_redirects' => false]);

        });
    }

    public function uploadFile(Request $request)
    {
        $file = $request->file;
        $file->storeAs('prueba', 'pruebitaPioilita', 'public');
    }


    public function confirmarTurno(Request $request)
    {
        DB::transaction(function() use ($request){
        $solicitud = $this->repo->update(['ESTADO' => 'Confirmado'], $request['IDSOLICITUD']);
        $turno = $this->turnosRepo->findBySolicitud($request['IDSOLICITUD']);
        $request['CONFIRMACION'] = 2;
        $request['MOTIVOT'] = null;
        $this->turnosRepo->update($request->all(), $turno->getId());
            $client = new Client();
            $userANotificar = Solicitud::find($solicitud->getId())->ASIGNADO;
            $r = $client->post( 'https://node-gestionar.herokuapp.com/actualizarClientes', ['json' => [$userANotificar], 'allow_redirects' => false]);

        });
    }

    public function rechazarTurno(Request $request)
    {
        DB::transaction(function() use ($request) {
            $solicitud = $this->repo->update(['ESTADO' => 'Pendiente'], $request['IDSOLICITUD']);
            $turno = $this->turnosRepo->findBySolicitud($request['IDSOLICITUD']);
            $request['CONFIRMACION'] = 1;
            $request['MOTIVOT'] = $request['motivo'];
            $this->turnosRepo->update($request->all(), $turno->getId());
            $client = new Client();
            $userANotificar = Solicitud::find($solicitud->getId())->ASIGNADO;
            $r = $client->post( 'https://node-gestionar.herokuapp.com/actualizarClientes', ['json' => [$userANotificar], 'allow_redirects' => false]);

        });
    }

    public function confirmadas($dni)
    {
        $service = new UserFromToken();
        $userRepo = new UserRepo();
        $user = $service->getUser();
        $obsUser = $user->obrasSociales->first();
        return DB::select(DB::raw("SELECT Solicitudes.IDS, Solicitudes.TIPO, Solicitudes.MEDICO, Climed.NOMBRE AS CLINICA, Climed.DIRECCION, Especialidad.NOMBRE AS ESP, Turnos.MEDICOASIGNADO, Turnos.FECHAT, Turnos.HORAT,Turnos.MOTIVOT
                  FROM Solicitudes 
                  INNER JOIN Turnos ON Solicitudes.IDS = Turnos.IDSOLICITUD
                    INNER JOIN Afiliados ON Solicitudes.DNISOLICITANTE = Afiliados.DNI
                     INNER JOIN Climed ON Solicitudes.IDCLIMED = Climed.IDCLI
                      INNER JOIN Especialidad ON Solicitudes.ESPECIALIDAD = Especialidad.IDESPECIALIDAD
                       WHERE Solicitudes.ESTADO='Confirmado' AND  Solicitudes.DNISOLICITANTE = '$dni' AND Afiliados.IDOBRASOCIAL = '$obsUser->ID' AND Turnos.CONFIRMACION = 2 "));

    }

    public function pendientesOAbiertas($dni)
    {
        $service = new UserFromToken();
        $userRepo = new UserRepo();
        $user = $service->getUser();
        $obsUser = $user->obrasSociales->first();
        $prueba =  DB::select(DB::raw("SELECT Solicitudes.IDS, Solicitudes.TIPO, Solicitudes.MEDICO,Solicitudes.FECHAS,Climed.NOMBRE AS CLINICA,Climed.DIRECCION,Especialidad.NOMBRE AS ESP
                                          FROM Solicitudes 
                                            INNER JOIN Afiliados ON Solicitudes.DNISOLICITANTE = Afiliados.DNI
                                              INNER JOIN Climed ON Solicitudes.IDCLIMED = Climed.IDCLI
                                               INNER JOIN Especialidad ON Solicitudes.ESPECIALIDAD = Especialidad.IDESPECIALIDAD
                                                WHERE (Solicitudes.ESTADO='Pendiente' OR Solicitudes.ESTADO='Abierto') AND Afiliados.IDOBRASOCIAL = '$obsUser->ID' AND Solicitudes.DNISOLICITANTE = '$dni'"));
        return $prueba;
    }

    public function enEspera($dni)
    {
        $service = new UserFromToken();
        $userRepo = new UserRepo();
        $user = $service->getUser();
        $obsUser = $user->obrasSociales->first();
        return DB::select(DB::raw("SELECT Solicitudes.IDS, Solicitudes.TIPO, Solicitudes.MEDICO, Climed.NOMBRE AS CLINICA, Climed.DIRECCION, Especialidad.NOMBRE AS ESP, Turnos.MEDICOASIGNADO, Turnos.FECHAT, Turnos.HORAT,Turnos.MOTIVOT
                                    FROM Solicitudes 
                                    LEFT JOIN Turnos ON Solicitudes.IDS = Turnos.IDSOLICITUD
                                    INNER JOIN Afiliados ON Solicitudes.DNISOLICITANTE = Afiliados.DNI
                                    INNER JOIN Climed ON Solicitudes.IDCLIMED = Climed.IDCLI 
                                    INNER JOIN Especialidad ON Solicitudes.ESPECIALIDAD = Especialidad.IDESPECIALIDAD
                                     WHERE Solicitudes.ESTADO='En Espera' AND Solicitudes.DNISOLICITANTE = '$dni' AND Afiliados.IDOBRASOCIAL = '$obsUser->ID' AND Turnos.CONFIRMACION = 0 "));

    }

    public function rechazadas($dni)
    {
        $service = new UserFromToken();
        $userRepo = new UserRepo();
        $user = $service->getUser();
        $obsUser = $user->obrasSociales->first();
        return DB::select(DB::raw("SELECT Solicitudes.IDS, Solicitudes.TIPO, Solicitudes.MEDICO,Solicitudes.FECHAS,Climed.NOMBRE AS CLINICA,Climed.DIRECCION,Especialidad.NOMBRE AS ESP 
                                    FROM Solicitudes
                                    INNER JOIN Afiliados ON Solicitudes.DNISOLICITANTE = Afiliados.DNI
                                     INNER JOIN Climed ON Solicitudes.IDCLIMED = Climed.IDCLI
                                      INNER JOIN Especialidad ON Solicitudes.ESPECIALIDAD = Especialidad.IDESPECIALIDAD
                                       WHERE Solicitudes.ESTADO='Rechazado' AND Afiliados.IDOBRASOCIAL = '$obsUser->ID' AND Solicitudes.DNISOLICITANTE = '$dni'"));
    }

    public function findApp($id)
    {
        $service = new UserFromToken();
        $userRepo = new UserRepo();
        $user = $service->getUser();
        $obsUser = $user->obrasSociales->first();
        return DB::select(DB::raw("SELECT Solicitudes.IDS,Solicitudes.IDAFILIADO, Solicitudes.MEDICO,Solicitudes.FECHAS,Climed.NOMBRE AS CLINICA,Climed.DIRECCION,Turnos.MEDICOASIGNADO,Turnos.FECHAT,Turnos.HORAT 
	      FROM 
	    ((Solicitudes INNER JOIN Climed ON Solicitudes.IDCLIMED = Climed.IDCLI) INNER JOIN Turnos ON Solicitudes.IDS = Turnos.IDSOLICITUD)
	    WHERE Solicitudes.IDS = '$id'"));
    }

    public function obtenerFamiliares()
    {
        $service = new UserFromToken();
        $user = $service->getUser();
        return $user->afiliado->familiares;
    }

}