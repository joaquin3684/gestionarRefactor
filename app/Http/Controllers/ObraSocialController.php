<?php

namespace App\Http\Controllers;

use App\Repositories\ObraSocialRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ObraSocialController extends Controller
{
    private $repo;

    public function __construct(ObraSocialRepo $repo)
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
        $obraSocial =  $this->repo->find($id);
        return $obraSocial->toArray($obraSocial);
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

            return $this->repo->all()->map(function ($elem) {
                return $elem->toArray($elem);
            });
    }
}
