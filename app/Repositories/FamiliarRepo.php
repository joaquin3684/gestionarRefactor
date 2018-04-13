<?php

namespace App\Repositories;


use App\Familiar;
use App\Repositories\Mapper\FamiliarMapper;

class FamiliarRepo extends Repositorio
{
    public function __construct()
    {
        $this->gateway = new Familiar();
        $this->mapper = new FamiliarMapper();
    }

    function model()
    {
        return 'App\Repositories\FamiliarRepo';
    }

}