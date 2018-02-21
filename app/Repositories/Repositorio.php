<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 27/05/17
 * Time: 00:45
 */

namespace App\Repositories;


use Illuminate\Container\Container as App;

abstract class Repositorio implements abmInterface
{
    private $app;
    protected $model;
    private $modeloEloquent;


    public function __construct() {
        $this->app = new App();
        $this->makeModel();
    }

    abstract function model();

    public function create(array $data)
    {
        $this->modeloEloquent = $this->gateway->create($data);
        return $this->mapper->map($this->modeloEloquent);
    }

    public function update(array $data, $id)
    {
        $obj = $this->gateway->find($id);
        $obj->fill($data);
        $obj->save();
        return $this->mapper->map($obj);
    }

    public function destroy($id)
    {
        return $this->gateway->destroy($id);

    }

    public function all()
    {
        $obj = $this->gateway->all();
        return $obj->map(function($obj){
            return $this->mapper->map($obj);
        });
    }

    public function find($id)
    {
        $obj = $this->gateway->find($id);
        return $this->mapper->map($obj);
    }

    public function findByUser($userId)
    {
        $obj = $this->gateway->findByUser($userId);
        return $this->mapper->map($obj);
    }

    public function attach($ids, $attach, $id)
    {
        $reserva = $this->gateway->find($id);
        $reserva->$attach()->attach($ids);
        return $this->mapper->map($reserva);
    }

    public function detach($detach, $id, $ids = null)
    {
        $obj = $this->gateway->find($id);
        if($ids == null)
        {
            $obj->$detach()->detach();
        }
        else
        {
            $obj->$detach()->detach($ids);
        }
    }

    public function makeModel() {
        $model = $this->app->make($this->model());
        return $this->model = $model;
    }
}