<?php

namespace App\Repositories\Mapper;

use App\Climed;

class ClimedMapper
{

    private $especialidadesMapper;
    private $obrasSocialesMapper;
    public function __construct()
    {
        $this->especialidadesMapper = new EspecialidadMapper();
        $this->obrasSocialesMapper = new ObraSocialMapper();
    }

    public function map($objeto)
    {
        if(is_a($objeto, 'Illuminate\Support\Collection'))
        {
            $clinicas = $objeto->map(function($objeto){
                $clinica =  new \App\Domain\Climed($objeto->IDCLI, $objeto->NOMBRE, $objeto->DIRECCION, $objeto->LOCALIDAD, $objeto->ZONA, $objeto->PARTICULAR, $objeto->latitude, $objeto->longitude, $objeto->TELEFONO);
                if($objeto->relationLoaded('especialidades'))
                {
                    $especialidades = $objeto->especialidades->map(function($especialidad){
                        return $this->especialidadesMapper->map($especialidad);
                    });
                    $clinica->setEspecialidades($especialidades);

                }
                if($objeto->relationLoaded('obrasSociales'))
                {
                    $obrasSociales = $objeto->obrasSociales->map(function($obraSocial){
                        return $this->obrasSocialesMapper->map($obraSocial);
                    });
                    $clinica->setObrasSociales($obrasSociales);
                }
                return $clinica;
            });

            return $clinicas;
        }
        else
        {
            $clinica =  new \App\Domain\Climed($objeto->IDCLI, $objeto->NOMBRE, $objeto->DIRECCION, $objeto->LOCALIDAD, $objeto->ZONA, $objeto->PARTICULAR, $objeto->latitude, $objeto->longitude, $objeto->TELEFONO);
            if($objeto->relationLoaded('especialidades'))
            {
                $especialidades = $objeto->especialidades->map(function($especialidad){
                    return $this->especialidadesMapper->map($especialidad);
                });
                $clinica->setEspecialidades($especialidades);
            }
            if($objeto->relationLoaded('obrasSociales'))
            {
                $obrasSociales = $objeto->obrasSociales->map(function($obraSocial){
                    return $this->obrasSocialesMapper->map($obraSocial);
                });
                $clinica->setObrasSociales($obrasSociales);
            }
            return $clinica;
        }




    }
}