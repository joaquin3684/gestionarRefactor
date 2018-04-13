<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $primaryKey = 'IDS';
    protected $table = 'Solicitudes';
    public $timestamps = false;

    protected $fillable = [
        'MEDICO', 'DNISOLICITANTE', 'FECHAS', 'ESTADO', 'ASIGNADO', 'IDAFILIADO', 'EQUIVALENCIA', 'IDCLIMED', 'MOTIVO', 'ESPECIALIDAD', 'TIPO', 'FOTO', 'REVISADO', 'OBS', 'FECHAMODIFICACION'
    ];

    public function turnos()
    {
        return $this->hasMany('App\Turno', 'IDSOLICITUD', 'IDS');
    }

    public function climed()
    {
        return $this->belongsTo('App\Climed', 'IDCLIMED', 'IDCLI');
    }

    public function especialidad()
    {
        return $this->belongsTo('App\Especialidad', 'ESPECIALIDAD', 'IDESPECIALIDAD');
    }

    public function afiliado()
    {
        return $this->belongsTo('App\Afiliado', 'DNISOLICITANTE', 'DNI');
    }
}
