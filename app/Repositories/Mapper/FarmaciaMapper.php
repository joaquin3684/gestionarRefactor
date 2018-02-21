<?php

namespace App\Repositories\Mapper;


class FarmaciaMapper
{

    public function map($objeto)
    {
        return new \App\Domain\Farmacia($objeto->ID, $objeto->NOMBRE, $objeto->DIRECCION, $objeto->LOCALIDAD, $objeto->latitude, $objeto->longitude, $objeto->TELEFONO);
    }
}