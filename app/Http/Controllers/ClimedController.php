<?php

namespace App\Http\Controllers;

use App\Repositories\ClimedRepo;
use App\Repositories\EspecialidadRepo;
use Illuminate\Http\Request;

class ClimedController extends Controller
{

    private $repo;

    public function __construct(ClimedRepo $repo, EspecialidadRepo $repoEspecialidades)
    {
        $this->repo = $repo;
        $this->especialidadesRepo = $repoEspecialidades;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $clinica = $this->repo->create($request->all());
        $this->repo->attach($request['obrasSociales'], 'obrasSociales', $clinica->getId());
        $this->repo->attach($request['especialidades'], 'especialidades', $clinica->getId());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $clinica =  $this->repo->findWithObrasSociales($id);
        return $clinica->toArray($clinica);
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
        $clinica = $this->repo->update($request->all(), $id);
        $this->repo->detach('obrasSociales', $id);
        $this->repo->attach($request['obrasSociales'], 'obrasSociales', $clinica->getId());

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
        return $this->repo->all()->map(function($elem){
            return $elem->toArray($elem);
        });
    }

    public function especialidades(Request $request)
    {
        $id = $request['id'];
        $clinica =  $this->repo->findEspecialidades($id);
        return $clinica->toArray($clinica);
    }
}
