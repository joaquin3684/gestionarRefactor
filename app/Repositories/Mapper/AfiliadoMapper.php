<?php

namespace App\Repositories\Mapper;

use App\Afiliado;

class AfiliadoMapper
{

    public function map($objeto)
    {
        return new \App\Domain\Afiliado($objeto->ID, $objeto->NOMBRE, $objeto->DNI, $objeto->APELLIDO, $objeto->EMAIL, $objeto->CELULAR, $objeto->TELEFONO, $objeto->DIRECCION, $objeto->PISO, $objeto->DEPARTAMENTO, $objeto->NACIMIENTO, $objeto->CUIL, $objeto->OBS, $objeto->GRUPOF, $objeto->NAFILIADO);
    }
}