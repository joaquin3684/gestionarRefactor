<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 11/10/17
 * Time: 20:57
 */

namespace App\Repositories;


use App\Exceptions\NoTieneAccesoAEstaObraSocialException;
use App\Repositories\Mapper\UserMapper;
use App\Services\UserFromToken;
use App\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserRepo extends Repositorio
{

    private $user;
    private $obsUser;
    public function __construct()
    {
        $this->gateway = new User();
        $this->mapper = new UserMapper();
        $token = JWTAuth::getToken();
        $userId = JWTAuth::decode($token)['user_id'];
        $this->user = $this->findWithAllRelationships($userId);
        $this->obsUser = $this->user->obrasSociales->map(function($obraSocial){ return $obraSocial->ID;});

    }

    function model()
    {
        return 'App\Repositories\UserRepo';
    }

    public function create(array $data)
    {
        $obrasSociales = $data['obrasSociales'];
        foreach ($obrasSociales as $obs)
        {
            if(!$this->obsUser->contains($obs))
            {
                throw new NoTieneAccesoAEstaObraSocialException('acceso denegado');
            }
        }
        $data['password'] = Hash::make($data['password']);
        $user = $this->gateway->create($data);
        parent::attach($data['obrasSociales'], 'obrasSociales', $user->id);
        return $user;
    }

    public function update(array $data, $id)
    {
        $obrasSociales = $data['obrasSociales'];
        foreach ($obrasSociales as $obs)
        {
            if(!$this->obsUser->contains($obs))
            {
                throw new NoTieneAccesoAEstaObraSocialException('acceso denegado');
            }
        }
        $data['password'] = Hash::make($data['password']);
        $user = $this->gateway->findOrFail($id);
        $user->fill($data)->save();
        parent::detach('obrasSociales', $id);
        parent::attach($data['obrasSociales'], 'obrasSociales', $user->id);
        return $user;
    }

    public function find($id)
    {
        $obj = $this->gateway->with('obrasSociales')->whereHas('obrasSociales', function($query){
            $query->whereIn('id_obra_social', $this->obsUser->toArray());
        })->findOrFail($id);
        return $this->mapper->map($obj);
    }

    public function all()
    {
        $obj = $this->gateway->with('obrasSociales')
            ->whereHas('obrasSociales', function($query){
                $query->whereIn('id_obra_social', $this->obsUser->toArray());
            })->get();
        return $obj->map(function($ob){
            return $this->mapper->map($ob);
        });
    }

    public function destroy($id)
    {
        $this->find($id);
        return parent::destroy($id);
    }



    public function findByCredentials($credentials)
    {
        return User::with('perfil.pantallas')->where('name', $credentials['name'])->first();
    }

    public function findWithAllRelationships($id)
    {
        return User::with('obrasSociales')->find($id);
    }
}