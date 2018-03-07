<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 11/10/17
 * Time: 20:57
 */

namespace App\Repositories;


use App\Repositories\Mapper\UserMapper;
use App\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserRepo extends Repositorio
{
    public function __construct()
    {
        $this->gateway = new User();
        $this->mapper = new UserMapper();
    }

    function model()
    {
        return 'App\Repositories\UserRepo';
    }

    public function create(array $data)
    {
        $user = $this->gateway->create(['name' => $data['name'], 'email' => $data['email'], 'password' => Hash::make($data['password'])]);
        $roles = $data['roles'];
        $user->roles()->sync($roles);
    }

    public function update(array $data, $id)
    {
        $user = $this->gateway->findOrFail($id);
        $user->fill($data)->save();
        $user->roles()->detach();
        $roles = $data['roles'];
        $user->roles()->sync($roles);

    }

    public function findByCredentials($credentials)
    {
        return User::where('name', $credentials['name'])->first();

    }
}