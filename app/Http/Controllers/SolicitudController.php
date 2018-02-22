<?php

namespace App\Http\Controllers;

use App\Repositories\SolicitudRepo;
use App\Repositories\TurnoRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SolicitudController extends Controller
{

    private $repo;
    private $turnosRepo;
    public function __construct(SolicitudRepo $repo, TurnoRepo $turnosRepo)
    {
        $this->repo = $repo;
        $this->turnosRepo  = $turnosRepo;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->repo->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $solicitud =  $this->repo->find($id);
        return $solicitud->toArray($solicitud);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->repo->update($request->all(), $id);
    }

    public function confirmarSolicitud(Request $request)
    {
        $this->repo->update(['ESTADO' => 'Confirmado'], $request['idsolicitud']);
        $turno = $this->turnosRepo->findBySolicitud($request['idsolicitud']);
        $this->turnosRepo->update(['CONFIRMACION' => 2], $turno->getId());
    }

    public function rechazarSolicitud(Request $request)
    {
        $this->repo->update(['ESTADO' => 'Pendiente'], $request['idsolicitud']);
        $turno = $this->turnosRepo->findBySolicitud($request['idsolicitud']);
        $this->turnosRepo->update(['CONFIRMACION' => 1, 'MOTIVOT' => $request['motivo']], $turno->getId());
    }

    public function destroy($id)
    {
        $this->repo->destroy($id);
    }

    public function all()
    {
        $solicitudes = $this->repo->all();
        return $solicitudes->map(function ($solicitud) {
            return $solicitud->toArray($solicitud);
        });
    }

    public function turnos(Request $request)
    {
        $id = $request['id'];
        $solicitud =  $this->repo->findTurnos($id);
        return $solicitud->toArray($solicitud);

    }

    public function pendientesOAbiertas(Request $request)
    {
        $dni = $request['dni'];
       $prueba =  DB::select(DB::raw("SELECT Solicitudes.IDS, Solicitudes.TIPO, Solicitudes.MEDICO,Solicitudes.FECHAS,Climed.NOMBRE AS CLINICA,Climed.DIRECCION,Especialidad.NOMBRE AS ESP FROM Solicitudes LEFT JOIN Climed ON Solicitudes.IDCLIMED = Climed.IDCLI LEFT JOIN Especialidad ON Solicitudes.ESPECIALIDAD = Especialidad.IDESPECIALIDAD WHERE Solicitudes.ESTADO='Pendiente' OR Solicitudes.ESTADO='Abierto' AND Solicitudes.DNISOLICITANTE = '$dni'"));
       return $prueba;
    }

    public function enEspera(Request $request)
    {
        $dni = $request['dni'];
        return DB::select(DB::raw("SELECT Solicitudes.IDS, Solicitudes.TIPO, Solicitudes.MEDICO, Climed.NOMBRE AS CLINICA, Climed.DIRECCION, Especialidad.NOMBRE AS ESP, Turnos.MEDICOASIGNADO, Turnos.FECHAT, Turnos.HORAT,Turnos.MOTIVOT FROM (Solicitudes LEFT JOIN Turnos ON Solicitudes.IDS = Turnos.IDSOLICITUD) LEFT JOIN Climed ON Solicitudes.IDCLIMED = Climed.IDCLI LEFT JOIN Especialidad ON Solicitudes.ESPECIALIDAD = Especialidad.IDESPECIALIDAD WHERE Solicitudes.ESTADO='En espera' AND Solicitudes.DNISOLICITANTE = '$dni' AND Turnos.CONFIRMACION = 0 "));

    }

    public function confirmadas(Request $request)
    {
        $dni = $request['dni'];
        return DB::select(DB::raw("SELECT Solicitudes.IDS, Solicitudes.TIPO, Solicitudes.MEDICO, Climed.NOMBRE AS CLINICA, Climed.DIRECCION, Especialidad.NOMBRE AS ESP, Turnos.MEDICOASIGNADO, Turnos.FECHAT, Turnos.HORAT,Turnos.MOTIVOT FROM (Solicitudes LEFT JOIN Turnos ON Solicitudes.IDS = Turnos.IDSOLICITUD) LEFT JOIN Climed ON Solicitudes.IDCLIMED = Climed.IDCLI LEFT JOIN Especialidad ON Solicitudes.ESPECIALIDAD = Especialidad.IDESPECIALIDAD WHERE Solicitudes.ESTADO='Confirmado' AND Solicitudes.DNISOLICITANTE = '$dni' AND Turnos.CONFIRMACION = 2 "));

    }

    public function rechazadas(Request $request)
    {
        $dni = $request['dni'];
        return DB::select(DB::raw("SELECT Solicitudes.IDS, Solicitudes.TIPO, Solicitudes.MEDICO,Solicitudes.FECHAS,Climed.NOMBRE AS CLINICA,Climed.DIRECCION,Especialidad.NOMBRE AS ESP FROM Solicitudes INNER JOIN Climed ON Solicitudes.IDCLIMED = Climed.IDCLI LEFT JOIN Especialidad ON Solicitudes.ESPECIALIDAD = Especialidad.IDESPECIALIDAD WHERE Solicitudes.ESTADO='Rechazado' AND Solicitudes.DNISOLICITANTE = '$dni'"));
    }

    public function findApp($id)
    {
        return DB::select(DB::raw("SELECT Solicitudes.IDS,Solicitudes.DNISOLICITANTE, Solicitudes.MEDICO,Solicitudes.FECHAS,Climed.NOMBRE AS CLINICA,Climed.DIRECCION,Turnos.MEDICOASIGNADO,Turnos.FECHAT,Turnos.HORAT 
	      FROM 
	    ((Solicitudes INNER JOIN Climed ON Solicitudes.IDCLIMED = Climed.IDCLI) INNER JOIN Turnos ON Solicitudes.IDS = Turnos.IDSOLICITUD)
	    WHERE Solicitudes.IDS = '$id'"));

    }
}
