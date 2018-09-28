<?php

namespace App\Repositories\Mapper;

use App\Solicitud;

class SolicitudMapper
{

    private $turnosMapper;
    private $afiliadoMapper;
    private $climedMapper;
    private $especialidadMapper;

    public function __construct()
    {
        $this->turnosMapper = new TurnoMapper();
        $this->afiliadoMapper = new AfiliadoMapper();
        $this->climedMapper = new ClimedMapper();
        $this->especialidadMapper = new EspecialidadMapper();
    }

    public function map($solicitud)
    {
        if(is_a($solicitud, 'Illuminate\Support\Collection'))
        {
            $solicitudes = $solicitud->map(function($solicitud){
                $solicitudMappeada = new \App\Domain\Solicitud($solicitud->IDS, $solicitud->MEDICO, $solicitud->FECHAS, $solicitud->ESTADO, $solicitud->ASIGNADO, $solicitud->MOTIVO, $solicitud->TIPO, $solicitud->FOTO, $solicitud->REVISADO, $solicitud->OBS, $solicitud->RANGO, $solicitud->OBSFAMILIAR);
                 $this->setearRelaciones($solicitud, $solicitudMappeada);
                 return $solicitudMappeada;
            });

            return $solicitudes;
        }
        else
        {
            $solicitudMappeada = new \App\Domain\Solicitud($solicitud->IDS, $solicitud->MEDICO, $solicitud->FECHAS, $solicitud->ESTADO, $solicitud->ASIGNADO, $solicitud->MOTIVO, $solicitud->TIPO, $solicitud->FOTO, $solicitud->REVISADO, $solicitud->OBS, $solicitud->RANGO, $solicitud->OBSFAMILIAR);
            $this->setearRelaciones($solicitud, $solicitudMappeada);
            return $solicitudMappeada;
        }
    }

    public function setearRelaciones($solicitud, &$solicitudMappeada)
    {
        if($solicitud->relationLoaded('turnos'))
        {
            $turnos = $solicitud->turnos->map(function($turno){
                return $this->turnosMapper->map($turno);
            });
            $solicitudMappeada->setTurnos($turnos);
        }
        if($solicitud->relationLoaded('afiliado'))
        {
            $afiliado = $this->afiliadoMapper->map($solicitud->afiliado);
            $solicitudMappeada->setAfiliado($afiliado);
        }
        if($solicitud->relationLoaded('climed') && $solicitud->climed != null)
        {
            $climed = $this->climedMapper->map($solicitud->climed);
            $solicitudMappeada->setClimed($climed);
        }
        if($solicitud->relationLoaded('especialidad') && $solicitud->especialidad != null)
        {
            $especialidad = $this->especialidadMapper->map($solicitud->especialidad);
            $solicitudMappeada->setEspecialidad($especialidad);
        }
        return $solicitudMappeada;

    }
}