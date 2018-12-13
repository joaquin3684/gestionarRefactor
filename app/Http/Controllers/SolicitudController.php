<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitudValidator;
use App\Repositories\SolicitudRepo;
use App\Repositories\TurnoRepo;
use App\Repositories\UserRepo;
use App\Solicitud;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class SolicitudController extends Controller
{

    private $repo;
    private $turnosRepo;
    private $userRepo;
    public function __construct(SolicitudRepo $repo, TurnoRepo $turnosRepo,  UserRepo $userRepo)
    {
        $this->repo = $repo;
        $this->turnosRepo  = $turnosRepo;
        $this->userRepo = $userRepo;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SolicitudValidator $request)
    {
        DB::transaction(function() use ($request) {

            $this->repo->create($request->all());
        });
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
        DB::transaction(function() use ($request, $id) {

            $this->repo->update($request->all(), $id);
        });
    }

    public function autorizarEstudio(Request $request)
    {
        DB::transaction(function() use ($request) {

            $this->repo->update($request->all(), $request['id']);
        });
    }


    public function autorizar(Request $request)
    {
        DB::transaction(function() use ($request) {

            $solicitud = $this->repo->update(['ESTADO' => 'Pendiente', 'REVISADO' => 1], $request['id']);
            $client = new Client();
            $obs = Solicitud::with('afiliado')->find($solicitud->getId())->afiliado->IDOBRASOCIAL;
            $usersANotificar = $this->userRepo->usersWithObraSocial($obs)->map(function($user){return $user->id;});
            $r = $client->post( 'https://node-gestionar.herokuapp.com/actualizarClientes', ['json' => $usersANotificar->toArray(), 'allow_redirects' => false]);

        });
    }

    public function rechazar(Request $request)
    {
        DB::transaction(function() use ($request) {

            $this->repo->update(['ESTADO' => 'Rechazado', 'REVISADO' => 1, 'MOTIVO' => $request['MOTIVO']], $request['id']);
        });
    }

    public function actualizarClinica(Request $request)
    {
        DB::transaction(function() use ($request) {

            $this->repo->update(['IDCLIMED' => $request['IDCLIMED']], $request['id']);
        });
    }

    public function solicitudesParaAuditar()
    {
        $solicitudes = $this->repo->solicitudesParaAuditar();
        return $solicitudes->map(function ($solicitud) {
            return $solicitud->toArray($solicitud);
        });
    }

    public function historialAuditoria()
    {
        $solicitudes = $this->repo->historialAuditoria();
        return $solicitudes->map(function ($solicitud) {
            return $solicitud->toArray($solicitud);
        });
    }

    public function historialCompleto()
    {
        $solicitudes = $this->repo->historialCompleto();
        return $solicitudes->map(function ($solicitud) {
            return $solicitud->toArray($solicitud);
        });
    }

    public function destroy($id)
    {
        DB::transaction(function() use ($id) {

            $this->repo->destroy($id);
        });
    }

    public function abrir(Request $request)
    {
        DB::transaction(function() use ($request){

            $usersANotificar = $this->repo->abrir($request['id']);
            $client = new Client();

           $r = $client->post( 'https://node-gestionar.herokuapp.com/actualizarClientes', ['json' => $usersANotificar->toArray(), 'allow_redirects' => false]);
        });
    }

    public function all()
    {
        $solicitudes = $this->repo->all();
        return $solicitudes->map(function ($solicitud) {
                return $solicitud->toArray($solicitud);
        });
    }

    public function solicitudesEnProceso()
    {
        $solicitudes = $this->repo->solicitudesEnProceso();
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
