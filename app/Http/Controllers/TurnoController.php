<?php

namespace App\Http\Controllers;

use App\Repositories\SolicitudRepo;
use App\Repositories\TurnoRepo;
use Illuminate\Http\Request;

class TurnoController extends Controller
{

    private $repo;
    private $solRepo;
    public function __construct(TurnoRepo $repo, SolicitudRepo $solRepo)
    {
        $this->repo = $repo;
        $this->solRepo = $solRepo;
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
        $this->solRepo->update(['ESTADO' => 'En Espera'], $request['IDSOLICITUD']);
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
    public function update(Request $request, $id)
    {
        $this->repo->update($request->all(), $id);
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

}
