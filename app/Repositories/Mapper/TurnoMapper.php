<?php

namespace App\Repositories\Mapper;

use App\Turno;

class TurnoMapper
{

    public function map($objeto)
    {
        return new \App\Domain\Turno($objeto->IDT, $objeto->FECHAT, $objeto->HORAT, $objeto->CONFIRMACION, $objeto->MEDICOASIGNADO, $objeto->MOTIVOT);
    }
}