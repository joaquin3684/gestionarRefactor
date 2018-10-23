<?php

namespace App\Repositories\Mapper;

use App\Turno;

class TurnoMapper
{
    private $climedMapper;

    public function __construct()
    {
        $this->climedMapper = new ClimedMapper();
    }
    public function map($objeto)
    {
        $turno =  new \App\Domain\Turno($objeto->IDT, $objeto->FECHAT, $objeto->HORAT, $objeto->CONFIRMACION, $objeto->MEDICOASIGNADO, $objeto->MOTIVOT, $objeto->FECHACREACION);
        if($objeto->relationLoaded('climed') && $objeto->climed != null)
        {
            $climed = $this->climedMapper->map($objeto->climed);
            $turno->setClimed($climed);
        }

        return $turno;

    }
}