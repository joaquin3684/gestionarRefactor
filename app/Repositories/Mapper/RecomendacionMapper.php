<?php

namespace App\Repositories\Mapper;

use App\Recomendacion;

class RecomendacionMapper
{

    public function map($recomendacion)
    {
        if(is_a($recomendacion, 'Illuminate\Support\Collection'))
        {
         $recomendaciones = $recomendacion->map(function($objeto){
             return new \App\Domain\Recomendacion($objeto->ID, $objeto->NOMBRE, $objeto->APELLIDO, $objeto->NRO, $objeto->FECHA, $objeto->CONTACTADO, $objeto->COMENTARIO);
         });
         return $recomendaciones;
        } else {
            return new \App\Domain\Recomendacion($recomendacion->ID, $recomendacion->NOMBRE, $recomendacion->APELLIDO, $recomendacion->NRO, $recomendacion->FECHA, $recomendacion->CONTACTADO, $recomendacion->COMENTARIO);
        }
    }
}