<?php

namespace App\Repositories\Mapper;


class FarmaciaMapper
{

    private $obrasSocialesMapper;
    public function __construct()
    {
        $this->obrasSocialesMapper = new ObraSocialMapper();
    }

    public function map($objeto)
    {
        $farmacia = new \App\Domain\Farmacia($objeto->ID, $objeto->NOMBRE, $objeto->DIRECCION, $objeto->LOCALIDAD, $objeto->latitude, $objeto->longitude, $objeto->TELEFONO);
        if($objeto->relationLoaded('obrasSociales'))
        {
            $obrasSociales = $objeto->obrasSociales->map(function($obraSocial){
                return $this->obrasSocialesMapper->map($obraSocial);
            });
            $farmacia->setObrasSociales($obrasSociales);
        }
        return $farmacia;
    }
}