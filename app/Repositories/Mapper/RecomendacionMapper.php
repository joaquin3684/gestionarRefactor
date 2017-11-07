<?php

namespace App\Repositories\Mapper;

use App\Recomendacion;

class RecomendacionMapper
{

    public function map($objeto)
    {
        return new \App\Domain\Recomendacion($objeto->ID, $objeto->NOMBRE, $objeto->APELLIDO, $objeto->NRO, $objeto->FECHA, $objeto->CONTACTADO, $objeto->COMENTARIO);
    }
}