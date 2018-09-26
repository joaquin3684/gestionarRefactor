<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 06/11/17
 * Time: 22:00
 */

namespace App\Domain;


use App\Traits\Conversion;

class Solicitud
{
    use Conversion;

    private $id;
    private $medico;
    private $fecha;
    private $estado;
    private $asignado;
    private $motivo;
    private $tipo;
    private $foto;
    private $revisado;
    private $obs;
    private $turnos;
    private $afiliado;
    private $climed;
    private $especialidad;
    private $rango;
    private $obsFamiliar;
    /**
     * Solicitud constructor.
     * @param $medico
     * @param $fecha
     * @param $estado
     * @param $asignado
     * @param $equivalencia
     * @param $motivo
     * @param $especialidad
     * @param $tipo
     * @param $foto
     * @param $revisado
     * @param $obs
     */
    public function __construct($id, $medico, $fecha, $estado, $asignado, $motivo, $tipo, $foto, $revisado, $obs, $rango, $obsFamiliar)
    {
        $this->id = $id;
        $this->medico = $medico;
        $this->fecha = $fecha;
        $this->estado = $estado;
        $this->asignado = $asignado;
        $this->motivo = $motivo;
        $this->tipo = $tipo;
        $this->foto = $foto;
        $this->revisado = $revisado;
        $this->obs = $obs;
        $this->rango = $rango;
        $this->obsFamiliar = $obsFamiliar;
    }

    /**
     * @return mixed
     */
    public function getAfiliado()
    {
        return $this->afiliado;
    }

    /**
     * @param mixed $afiliado
     */
    public function setAfiliado($afiliado)
    {
        $this->afiliado = $afiliado;
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
    public function getMedico()
    {
        return $this->medico;
    }

    /**
     * @param mixed $medico
     */
    public function setMedico($medico)
    {
        $this->medico = $medico;
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
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * @return mixed
     */
    public function getAsignado()
    {
        return $this->asignado;
    }

    /**
     * @param mixed $asignado
     */
    public function setAsignado($asignado)
    {
        $this->asignado = $asignado;
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
    public function getEspecialidad()
    {
        return $this->especialidad;
    }

    /**
     * @param mixed $especialidad
     */
    public function setEspecialidad($especialidad)
    {
        $this->especialidad = $especialidad;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * @return mixed
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * @param mixed $foto
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;
    }

    /**
     * @return mixed
     */
    public function getRevisado()
    {
        return $this->revisado;
    }

    /**
     * @param mixed $revisado
     */
    public function setRevisado($revisado)
    {
        $this->revisado = $revisado;
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

    /**
     * @return mixed
     */
    public function getTurnos()
    {
        return $this->turnos;
    }

    /**
     * @param mixed $turnos
     */
    public function setTurnos($turnos)
    {
        $this->turnos = $turnos;
    }



}