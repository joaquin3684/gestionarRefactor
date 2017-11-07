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
}