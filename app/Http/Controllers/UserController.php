<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserValidator;
use App\Repositories\UserRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    private $repo;
    public function __construct(UserRepo $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserValidator $request)
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
        $this->repo->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserValidator $request, $id)
    {
        DB::transaction(function() use ($request, $id) {
            $this->repo->update($request->all(), $id);
        });
    }

    public function cambiarContraseña(Request $request)
    {
        DB::transaction(function() use ($request){
            $this->repo->cambiarContraseña($request->all());
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
        return $this->repo->all();
    }
}
