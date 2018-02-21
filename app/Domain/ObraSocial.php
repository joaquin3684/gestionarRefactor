<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 18/02/18
 * Time: 17:26
 */

namespace App\Domain;


use App\Traits\Conversion;

class ObraSocial
{
    use Conversion;

    private $id;
    private $nombre;
    private $clinicas;
    private $afiliados;

    /**
     * ObraSocial constructor.
     * @param $id
     * @param $nombre
     */
    public function __construct($id, $nombre)
    {
        $this->id = $id;
        $this->nombre = $nombre;
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
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getClinicas()
    {
        return $this->clinicas;
    }

    /**
     * @param mixed $clinicas
     */
    public function setClinicas($clinicas)
    {
        $this->clinicas = $clinicas;
    }

    /**
     * @return mixed
     */
    public function getAfiliados()
    {
        return $this->afiliados;
    }

    /**
     * @param mixed $afiliados
     */
    public function setAfiliados($afiliados)
    {
        $this->afiliados = $afiliados;
    }


}