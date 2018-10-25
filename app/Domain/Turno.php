<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 06/11/17
 * Time: 22:19
 */

namespace App\Domain;


use App\Traits\Conversion;

class Turno
{
    use Conversion;

    private $id;
    private $fecha;
    private $hora;
    private $confirmacion;
    private $medicoAsignado;
    private $motivo;
    private $climed;
    private $fechaCreacion;
    private $obs;


    /**
     * Turno constructor.
     * @param $id
     * @param $fecha
     * @param $hora
     * @param $confirmacion
     * @param $medicoAsignado
     * @param $motivo
     * @param $obs
     */
    public function __construct($id, $fecha, $hora, $confirmacion, $medicoAsignado, $motivo, $fechaCreacion, $obs)
    {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->confirmacion = $confirmacion;
        $this->medicoAsignado = $medicoAsignado;
        $this->motivo = $motivo;
        $this->fechaCreacion = $fechaCreacion;
        $this->obs = $obs;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * @param mixed $hora
     */
    public function setHora($hora)
    {
        $this->hora = $hora;
    }

    /**
     * @return mixed
     */
    public function getConfirmacion()
    {
        return $this->confirmacion;
    }

    /**
     * @param mixed $confirmacion
     */
    public function setConfirmacion($confirmacion)
    {
        $this->confirmacion = $confirmacion;
    }

    /**
     * @return mixed
     */
    public function getMedicoAsignado()
    {
        return $this->medicoAsignado;
    }

    /**
     * @param mixed $medicoAsignado
     */
    public function setMedicoAsignado($medicoAsignado)
    {
        $this->medicoAsignado = $medicoAsignado;
    }

    /**
     * @return mixed
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * @param mixed $motivo
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
    }


    /**
     * @return mixed
     */
    public function getClimed()
    {
        return $this->climed;
    }

    /**
     * @param mixed $climed
     */
    public function setClimed($climed)
    {
        $this->climed = $climed;
    }

    /**
     * @return mixed
     */
    public function getObs()
    {
        return $this->obs;
    }

    /**
     * @param mixed $obs
     */
    public function setObs($obs)
    {
        $this->obs = $obs;
    }


}