<?php

namespace App\Repositories;


use App\Roles;
use App\Repositories\Mapper\RolesMapper;

class RolesRepo extends Repositorio
{
    public function __construct()
    {
        $this->gateway = new Roles();
        $this->mapper = new RolesMapper();
    }

    function model()
    {
        return 'App\Repositories\RolesRepo';
    }

}