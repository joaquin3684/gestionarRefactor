<?php

namespace App\Repositories;


use App\Afiliado;
use App\Familiar;
use App\Perfil;
use App\Repositories\Mapper\AfiliadoMapper;
use App\Exceptions\NoTieneAccesoAEstaObraSocialException;
use App\Services\UserFromToken;
use App\User;
use Illuminate\Support\Facades\Hash;

class AfiliadoRepo extends Repositorio
{
    private $user;
    private $obsUser;
    private $userRepo;
    public function __construct()
    {
        $this->gateway = new Afiliado();
        $this->mapper = new AfiliadoMapper();
        $service = new UserFromToken();
        $this->userRepo = new UserRepo();
        $this->user = $service->getUser();
        $this->obsUser = $this->user->obrasSociales->map(function($obraSocial){ return $obraSocial->ID;});
    }

    function model()
    {
        return 'App\Repositories\AfiliadoRepo';
    }


    public function create(array $data)
    {
        $obra = $this->obsUser->first(function($obraSocial) use ($data){
            return $obraSocial == $data['IDOBRASOCIAL'];
        });
        if($obra == null)
        {
            throw new NoTieneAccesoAEstaObraSocialException('acceso denegado');
        } else {

            $data['name'] = $data['DNI'];
            $data['password'] = $data['NAFILIADO'];
            $data['email'] = $data['EMAIL'];
            $data['id_perfil'] = 1;
            $data['obrasSociales'] = array($data['IDOBRASOCIAL']);
            $user = $this->userRepo->create($data);
            $data['id_usuario'] = $user->id;
            $afiliado = $this->gateway->create($data);
            $col = collect($data['familiares']);
            $familiares = $col->map(function($c) use ($afiliado){
                $c['id_afiliado'] = $afiliado->DNI;
                return $c;
            });
            Familiar::insert($familiares->toArray());
            //TODO para que esto funcione el perfil 1 tiene que ser el de afiliado
            return $afiliado;
        }
    }

    public function update(array $data, $id)
    {
        $obra = $this->obsUser->first(function($obraSocial) use ($data){
            return $obraSocial == $data['IDOBRASOCIAL'];
        });
        if($obra == null)
        {
            throw new NoTieneAccesoAEstaObraSocialException('acceso denegado');
        } else {
           $afiliado = $this->gateway->find($id);
           $afiliado->fill($data)->save();
            $data['name'] = $data['DNI'];
            $data['password'] = $data['NAFILIADO'];
            $data['email'] = $data['EMAIL'];
            $data['id_perfil'] = 1;
            $data['obrasSociales'] = array($data['IDOBRASOCIAL']);
            $user = $this->userRepo->update($data, $afiliado->id_usuario);
            $col = collect($data['familiares']);
            $familiares = $col->map(function($c) use ($afiliado){
                $c['id_afiliado'] = $afiliado->DNI;
                return $c;
            });
            Familiar::where('id_afiliado', $afiliado->id)->delete();
            Familiar::insert($familiares->toArray());

            return $afiliado;
        }
    }

    public function find($id)
    {
        $obj = $this->gateway->with('obraSocial', 'familiares')->whereHas('obraSocial', function($query){
            $query->whereIn('ID', $this->obsUser->toArray());
        })->findOrFail($id);
        return $this->mapper->map($obj);
    }

    public function all()
    {
        $obj = $this->gateway->with('obraSocial', 'familiares')
            ->whereHas('obraSocial', function($query){
                $query->whereIn('ID', $this->obsUser->toArray());
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




}