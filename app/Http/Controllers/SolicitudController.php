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
