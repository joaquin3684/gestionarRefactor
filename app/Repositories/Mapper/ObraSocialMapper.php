<?php

namespace App\Repositories\Mapper;

use App\ObraSocial;

class ObraSocialMapper
{

    public function map($objeto)
    {
        return new \App\Domain\ObraSocial($objeto->ID, $objeto->NOMBRE);
    }
}