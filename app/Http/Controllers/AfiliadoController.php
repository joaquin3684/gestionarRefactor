<?php

namespace App\Http\Controllers;

use App\Domain\ValidadorObraSocial;
use App\Http\Requests\AfiliadoValidator;
use App\Repositories\AfiliadoRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AfiliadoController extends Controller
{
    private $repo;

    public function __construct(AfiliadoRepo $repo)
    {
        $this->repo = $repo;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AfiliadoValidator $request)
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
    public function update(AfiliadoValidator $request, $id)
    {
        DB::transaction(function() use ($request, $id) {

            $this->repo->update($request->all(), $id);
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
        DB::transaction(function() use ($id) {

            $this->repo->destroy($id);
        });
    }

    public function all()
    {
        return $this->repo->all()->map(function($elem){
               return $elem->toArray($elem);
        });
    }

}
