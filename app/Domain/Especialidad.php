<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 06/11/17
 * Time: 20:25
 */

namespace App\Domain;


use App\Traits\Conversion;

class Especialidad
{
    use Conversion;

    private $id;
    private $nombre;
    private $estudio;

    /**
     * Especialidad constructor.
     * @param $id
     * @param $nombre
     * @param $estudio
     */
    public function __construct($id, $nombre, $estudio)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->estudio = $estudio;
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
    public function getEstudio()
    {
        return $this->estudio;
    }

    /**
     * @param mixed $estudio
     */
    public function setEstudio($estudio)
    {
        $this->estudio = $estudio;
    }


}