<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecomendacionValidator;
use App\Repositories\RecomendacionRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecomendacionController extends Controller
{

    private $repo;

    public function __construct(RecomendacionRepo $repo)
    {
        $this->repo = $repo;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RecomendacionValidator $request)
    {
        DB::transaction(function() use ($request){
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
    public function update(RecomendacionValidator $request, $id)
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
        return $this->repo->all()->map(function ($elem) {
            return $elem->toArray($elem);
        });
    }

    public function recomendacionesSinContactar()
    {
        return $this->repo->recomendacionesSinContactar()->map(function ($elem) {
            return $elem->toArray($elem);
        });
    }

    public function contactado(Request $request)
    {
        DB::transaction(function() use ($request){

            foreach($request['ids'] as $id){

                $this->repo->update(['CONTACTADO' => 1], $id);
            }
        });
    }
}
