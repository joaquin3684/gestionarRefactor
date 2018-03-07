<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 06/03/18
 * Time: 18:40
 */

namespace App\Repositories;


use App\Repositories\Mapper\RoleMapper;
use Spatie\Permission\Models\Role;

class RoleRepo extends Repositorio
{

    public function __construct()
    {
        $this->gateway = new Role();
        $this->mapper = new RoleMapper();
    }

    function model()
    {
        return 'App\Repositories\RoleRepo';
    }

    public function create(array $data)
    {
        $role = $this->gateway->create(['name' => $data['name']]);
        $role->permissions()->sync($data['permisos']);
    }

    public function update(array $data, $id)
    {
        $role = $this->gateway->findOrFail($id);
        $role->fill($data)->save();
        $role->syncPermissions($data['permisos']);
    }
}