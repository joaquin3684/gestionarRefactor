<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteSolicitudesController extends Controller
{

    public function porZona(Request $request)
    {

        return DB::table('Solicitudes')
            ->join('Climed', 'Climed.IDCLI', 'Solicitudes.IDCLIMED')
            ->groupBy('Climed.ZONA')
            ->whereBetween('Solicitudes.FECHAMODIFICACION', [$request['fecha_modificacion_desde'], $request['fecha_modificacion_hasta']])
            ->whereBetween('Solicitudes.FECHAS', [$request['fecha_creacion_desde'], $request['fecha_creacion_hasta']])
            ->select('Climed.ZONA as zona', DB::raw('COUNT(Solicitudes.IDS) AS total'),
                DB::raw('COUNT(CASE WHEN Solicitudes.ESTADO = "Pendiente" then 1 ELSE NULL END) as "pendientes",
                            COUNT(CASE WHEN Solicitudes.ESTADO = "Rechazado" then 1 ELSE NULL END) as "rechazados",
                            COUNT(CASE WHEN Solicitudes.ESTADO = "Confirmado" then 1 ELSE NULL END) as "confirmados"'))->get();
    }

    public function porClinica(Request $request)
    {
        return DB::table('Solicitudes')
            ->join('Climed', 'Climed.IDCLI', 'Solicitudes.IDCLIMED')
            ->groupBy('Climed.NOMBRE')
            ->whereBetween('Solicitudes.FECHAMODIFICACION', [$request['fecha_modificacion_desde'], $request['fecha_modificacion_hasta']])
            ->whereBetween('Solicitudes.FECHAS', [$request['fecha_creacion_desde'], $request['fecha_creacion_hasta']])
            ->where('Climed.ZONA', $request['zona'])
            ->select('Climed.NOMBRE as nombre', DB::raw('COUNT(Solicitudes.IDS) AS total'),
                DB::raw('COUNT(CASE WHEN Solicitudes.ESTADO = "Pendiente" then 1 ELSE NULL END) as "pendientes",
                            COUNT(CASE WHEN Solicitudes.ESTADO = "Rechazado" then 1 ELSE NULL END) as "rechazados",
                            COUNT(CASE WHEN Solicitudes.ESTADO = "Confirmado" then 1 ELSE NULL END) as "confirmados"'))->get();

    }

    public function porSolicitud(Request $request)
    {
        return DB::table('Solicitudes')
            ->whereBetween('FECHAMODIFICACION', [$request['fecha_modificacion_desde'], $request['fecha_modificacion_hasta']])
            ->whereBetween('FECHAS', [$request['fecha_creacion_desde'], $request['fecha_creacion_hasta']])
            ->where('IDCLIMED', $request['id_clinica'])
            ->select('IDS as id', 'FECHAS as fechaCreacion', 'ESTADO as estado', 'MOTIVO as motivo', 'FECHAMODIFICACION as fechaModificacion')->get();
    }

    public function porTurnos(Request $request)
    {
        return DB::table('turnos')
            ->where('IDSOLICITUD', $request['id_solicitud'])
            ->select('IDT as id', 'FECHACREACION as fechaCreacion', 'FECHAT as fechaTurno', 'HORAT as horaTurno', 'CONFIRMACION as confirmacion', 'MEDICOASIGNADO as medicoAsignado', 'MOTIVOT as motivo')->get();
    }
}
