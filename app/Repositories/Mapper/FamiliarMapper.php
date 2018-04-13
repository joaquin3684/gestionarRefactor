<?php

namespace App\Repositories\Mapper;

use App\Familiar;

class FamiliarMapper
{

    public function map($objeto)
    {
        if(is_a($objeto, 'Illuminate\Support\Collection'))
        {
            $familiares = $objeto->map(function($obj){
                return new \App\Domain\Familiar($obj->nombre, $obj->apellido, $obj->nacimiento, $obj->cuil, $obj->nafiliado, $obj->dni);
            });
            return $familiares;
        } else {
            return new \App\Domain\Familiar($objeto->nombre, $objeto->apellido, $objeto->nacimiento, $objeto->cuil, $objeto->nafiliado, $objeto->dni);

        }


    }
}