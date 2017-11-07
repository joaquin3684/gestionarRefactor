<?php

namespace App\Repositories\Mapper;

use App\Especialidad;

class EspecialidadMapper
{

    public function map($objeto)
    {
        return new \App\Domain\Especialidad($objeto->IDESPECIALIDAD, $objeto->NOMBRE, $objeto->ESTUDIO);
    }
}