<?php

namespace App\Http\Controllers\Aplicacion;

use App\Http\Controllers\Controller;
use App\Repositories\SolicitudRepo;
use App\Repositories\TurnoRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppSolicitudController extends Controller
{

    private $repo;
    private $turnosRepo;
    public function __construct(SolicitudRepo $repo, TurnoRepo $turnosRepo)
    {
        $this->repo = $repo;
        $this->turnosRepo  = $turnosRepo;
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

    public function confirmadas(Request $request)
    {
        $dni = $request['dni'];
        return DB::select(DB::raw("SELECT Solicitudes.IDS, Solicitudes.TIPO, Solicitudes.MEDICO, Climed.NOMBRE AS CLINICA, Climed.DIRECCION, Especialidad.NOMBRE AS ESP, Turnos.MEDICOASIGNADO, Turnos.FECHAT, Turnos.HORAT,Turnos.MOTIVOT FROM (Solicitudes LEFT JOIN Turnos ON Solicitudes.IDS = Turnos.IDSOLICITUD) LEFT JOIN Climed ON Solicitudes.IDCLIMED = Climed.IDCLI LEFT JOIN Especialidad ON Solicitudes.ESPECIALIDAD = Especialidad.IDESPECIALIDAD WHERE Solicitudes.ESTADO='Confirmado' AND Solicitudes.DNISOLICITANTE = '$dni' AND Turnos.CONFIRMACION = 2 "));

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