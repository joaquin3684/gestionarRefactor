<?php

namespace App\Http\Controllers;

use App\Repositories\SolicitudRepo;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{

    private $repo;

    public function __construct(SolicitudRepo $repo)
    {
        $this->repo = $repo;
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
}
