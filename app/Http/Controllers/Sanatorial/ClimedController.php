<?php

namespace App\Http\Controllers\Sanatorial;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClimedValidator;
use App\Repositories\ClimedRepo;
use App\Repositories\EspecialidadRepo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

class ClimedController extends Controller
{

    private $repo;

    public function __construct()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function clinicas()
    {
        return DB::select(DB::raw("SELECT Climed.IDCLI,Climed.NOMBRE,Climed.ZONA,Climed.DIRECCION,Climed.LOCALIDAD,Climed.latitude,Climed.longitude, Especialidad.NOMBRE AS ESPECIALIDAD, Climed.TELEFONO FROM Climed
          INNER JOIN ClimedEsp ON (Climed.IDCLI = ClimedEsp.IDCLIMED)
           INNER JOIN Especialidad ON (ClimedEsp.IDESP = Especialidad.IDESPECIALIDAD)
           INNER JOIN Climed_obra_social ON Climed.IDCLI = Climed_obra_social.IDCLIMED
           WHERE Climed_obra_social.IDOBRASOCIAL = 2
            ORDER BY Climed.NOMBRE"));


    }

    public function farmacias()
    {
        return DB::select(DB::raw("SELECT Farmacias.* FROM Farmacias
           INNER JOIN Farmacia_obra_social ON Farmacias.ID = Farmacia_obra_social.id_farmacia
            WHERE Farmacia_obra_social.id_obra_social = 2
            ORDER BY Farmacias.NOMBRE"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $clinica =  $this->repo->find($id);
        return $clinica->toArray($clinica);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClimedValidator $request, $id)
    {
        DB::transaction(function() use ($request, $id){

            $clinica = $this->repo->update($request->all(), $id);
            $this->repo->detach('obrasSociales', $id);
            $this->repo->attach($request['obrasSociales'], 'obrasSociales', $clinica->getId());
            $this->repo->detach('especialidades', $id);
            $this->repo->attach($request['especialidades'], 'especialidades', $id);
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repo->destroy($id);
    }

    public function all()
    {
        return $this->repo->all()->map(function ($elem) {
            return $elem->toArray($elem);
        });
    }

    public function especialidades(Request $request)//TODO ESTE METODO SE PODRIA SACAR POQUE ES IGUAL QUE UN FIND
    {
        $id = $request['id'];
        $clinica =  $this->repo->find($id);
        return $clinica->toArray($clinica);
    }


}
