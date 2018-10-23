<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 22/02/18
 * Time: 17:05
 */

namespace App\Http\Controllers\Aplicacion;


use App\Climed;
use App\Especialidad;
use App\Http\Controllers\Controller;
use App\Repositories\ClimedRepo;
use App\Repositories\EspecialidadRepo;
use App\Repositories\UserRepo;
use App\Services\UserFromToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppClimedController extends Controller
{
    private $userRepo;
    private $obsUser;
    private $user;
    private $repo;
    public function __construct(ClimedRepo $repo)
    {
       // $this->obsUser = collect([1,2,3]);
        $this->repo = $repo;
        $service = new UserFromToken();
       $this->userRepo = new UserRepo();
        $this->user = $service->getUser();
         $this->obsUser = $this->user->obrasSociales->map(function($obraSocial){ return $obraSocial->ID;});
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
        $obraSocial = $this->obsUser->first();

        $especialidad = $request['especialidad'];
        $localidad = $request['localidad'];
        return DB::select(DB::raw("SELECT Climed.IDCLI,Climed.NOMBRE,Climed.DIRECCION,Climed.LOCALIDAD,Climed.latitude,Climed.longitude, Especialidad.NOMBRE AS ESPECIALIDAD
                        FROM Climed 
	                    INNER JOIN ClimedEsp ON Climed.IDCLI = ClimedEsp.IDCLIMED
	                    INNER JOIN Especialidad ON ClimedEsp.IDESP = Especialidad.IDESPECIALIDAD
	                    INNER JOIN Climed_obra_social ON Climed.IDCLI = Climed_obra_social.IDCLIMED
	                    WHERE Especialidad.IDESPECIALIDAD = '$especialidad' AND Climed.LOCALIDAD = '$localidad' AND Climed_obra_social.IDOBRASOCIAL = '$obraSocial' AND Climed.deleted_at IS NULL AND Especialidad.deleted_at IS NULL
	                    GROUP BY Climed.IDCLI,Climed.NOMBRE,Climed.DIRECCION,Climed.LOCALIDAD,Climed.latitude,Climed.longitude, Especialidad.NOMBRE ORDER BY Climed.NOMBRE "));

    }

    public function all()
    {
        return Climed::whereHas('obrasSociales', function($query){
            $query->whereIn('IDOBRASOCIAL', $this->obsUser->toArray());
        })->where('PARTICULAR', 0)->get();
      // return Climed::all();
    }

    public function clinicass()
    {
        return Climed::whereHas('obrasSociales', function($query){
            $query->whereIn('IDOBRASOCIAL', $this->obsUser->toArray());
        })->where('PARTICULAR', 0)->get();
    }

    public function particularess()
    {
        return Climed::whereHas('obrasSociales', function($query){
            $query->whereIn('IDOBRASOCIAL', $this->obsUser->toArray());
        })->where('PARTICULAR', 1)->get();
    }

    public function allParticulares()
    {
        return Climed::whereHas('obrasSociales', function($query){
            $query->whereIn('IDOBRASOCIAL', $this->obsUser->toArray());
        })->where('PARTICULAR', 1)->get();
    }

    public function find($id)
    {
        return Climed::whereHas('obrasSociales', function($query){
            $query->whereIn('IDOBRASOCIAL', $this->obsUser->toArray());
        })->find($id);
        return Climed::find($id);
    }

    public function especialidadesClinica($clinicaId)
    {
        return Climed::whereHas('obrasSociales', function($query){
            $query->whereIn('IDOBRASOCIAL', $this->obsUser->toArray());
        })->with('especialidades')->find($clinicaId)->especialidades;
    }


    public function localidadesEspecialidad($id)
    {
        $obraSocial = $this->obsUser->first();

        return DB::select(DB::raw("SELECT Climed.LOCALIDAD
                        FROM Climed 
	                    INNER JOIN ClimedEsp ON Climed.IDCLI = ClimedEsp.IDCLIMED
	                    INNER JOIN Especialidad ON ClimedEsp.IDESP = Especialidad.IDESPECIALIDAD
	                    INNER JOIN Climed_obra_social ON Climed.IDCLI = Climed_obra_social.IDCLIMED
	                    WHERE Especialidad.IDESPECIALIDAD = '$id' and Climed_obra_social.IDOBRASOCIAL = '$obraSocial'  AND Climed.deleted_at IS NULL AND Especialidad.deleted_at IS NULL
	                    GROUP BY Climed.LOCALIDAD ORDER BY Climed.LOCALIDAD "));

    }

    public function localidadesEspecialidadClinico()
    {
        $obraSocial = $this->obsUser->first();

        return DB::select(DB::raw("SELECT Climed.LOCALIDAD
                        FROM Climed 
	                    INNER JOIN ClimedEsp ON Climed.IDCLI = ClimedEsp.IDCLIMED
	                    INNER JOIN Especialidad ON ClimedEsp.IDESP = Especialidad.IDESPECIALIDAD
	                    INNER JOIN Climed_obra_social ON Climed.IDCLI = Climed_obra_social.IDCLIMED
	                    WHERE Especialidad.IDESPECIALIDAD = '40' and Climed_obra_social.IDOBRASOCIAL = '$obraSocial' AND Climed.deleted_at IS NULL AND Especialidad.deleted_at IS NULL
	                    ORDER BY Climed.LOCALIDAD "));

    }

    public function especialidades()
    {
        /*return DB::select(DB::raw("SELECT *
                        FROM Especialidad
	                    ORDER BY Especialidad.NOMBRE"));*/

        $obraSocial = $this->obsUser->first();

        return DB::select(DB::raw("SELECT Especialidad.NOMBRE, Especialidad.IDESPECIALIDAD
                        FROM Climed 
	                    INNER JOIN ClimedEsp ON Climed.IDCLI = ClimedEsp.IDCLIMED
	                    INNER JOIN Especialidad ON ClimedEsp.IDESP = Especialidad.IDESPECIALIDAD
	                    INNER JOIN Climed_obra_social ON Climed.IDCLI = Climed_obra_social.IDCLIMED
	                    WHERE  Climed_obra_social.IDOBRASOCIAL = '$obraSocial' AND Climed.deleted_at IS NULL AND Especialidad.deleted_at IS NULL AND Especialidad.ESTUDIO = 0
	                    GROUP BY Especialidad.NOMBRE, Especialidad.IDESPECIALIDAD
	                    ORDER BY Especialidad.NOMBRE"));
    }


}