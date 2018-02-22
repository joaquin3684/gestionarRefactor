<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 22/02/18
 * Time: 17:05
 */

namespace App\Http\Controllers\Aplicacion;


use App\Http\Controllers\Controller;
use App\Repositories\ClimedRepo;
use App\Repositories\EspecialidadRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppClimedController extends Controller
{
    private $repo;

    public function __construct(ClimedRepo $repo, EspecialidadRepo $repoEspecialidades)
    {
        $this->repo = $repo;
        $this->especialidadesRepo = $repoEspecialidades;
    }

    public function findClinicasByEspecialidad($id)
    {
        $clinicas = $this->repo->findClinicasByEspecialidad($id);
        return $clinicas->map(function($clinica) {
            return $clinica->toArray($clinica);
        });

    }

    public function findClinicasByEspecialidadAndLocalidad(Request $request)
    {
        $especialidad = $request['especialidad'];
        $localidad = $request['localidad'];
        return DB::select(DB::raw("SELECT Climed.IDCLI,Climed.NOMBRE,Climed.DIRECCION,Climed.LOCALIDAD,Climed.latitude,Climed.longitude, Especialidad.NOMBRE AS ESPECIALIDAD FROM Climed 
	                    INNER JOIN ClimedEsp ON Climed.IDCLI = ClimedEsp.IDCLIMED
	                    INNER JOIN Especialidad ON ClimedEsp.IDESP = Especialidad.IDESPECIALIDAD
	                    WHERE Especialidad.IDESPECIALIDAD = '$especialidad' AND Climed.LOCALIDAD = '$localidad'
	                    GROUP BY Climed.IDCLI ORDER BY Climed.NOMBRE ASC"));

    }
}