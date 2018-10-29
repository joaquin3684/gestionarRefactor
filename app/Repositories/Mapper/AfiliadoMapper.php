<?php

namespace App\Repositories\Mapper;

use App\Afiliado;

class AfiliadoMapper
{

    private $obraSocialMapper;
    public function __construct()
    {
        $this->obraSocialMapper = new ObraSocialMapper();
        $this->familiarMapper = new FamiliarMapper();
    }

    public function map($objeto)
    {
        $afiliado = new \App\Domain\Afiliado($objeto->ID, $objeto->NOMBRE, $objeto->DNI, $objeto->APELLIDO, $objeto->EMAIL, $objeto->CELULAR, $objeto->TELEFONO, $objeto->DIRECCION, $objeto->PISO, $objeto->DEPARTAMENTO, $objeto->NACIMIENTO, $objeto->CUIL, $objeto->OBS, $objeto->GRUPOF, $objeto->NAFILIADO, $objeto->PLAN, $objeto->localidad, $objeto->cp, $objeto->IDNOTIF);
        if($objeto->relationLoaded('obraSocial'))
        {
            $obraSocial = $this->obraSocialMapper->map($objeto->obraSocial);
            $afiliado->setObraSocial($obraSocial);
        }
        if($objeto->relationLoaded('familiares'))
        {
            $familiares = $this->familiarMapper->map($objeto->familiares);
            $afiliado->setFamiliares($familiares);
        }

        return $afiliado;
    }
}