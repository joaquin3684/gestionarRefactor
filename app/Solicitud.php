<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $primaryKey = 'IDS';
    protected $table = 'Solicitudes';
    protected $fillable = [
        'IDSOLICITANTE', 'MEDICO', 'FECHAS', 'ESTADO', 'ASIGNADO', 'IDAFILIADO', 'EQUIVALENCIA', 'IDCLIMED', 'MOTIVO', 'ESPECIALIDAD', 'TIPO', 'FOTO', 'REVISADO', 'OBS'
    ];

    public function turnos()
    {
        return $this->hasMany('App\Turno', 'IDSOLICITUD', 'IDS');
    }

    public function climed()
    {
        return $this->belongsTo('App\Climed', 'IDCLIMED', 'IDS');
    }

    public function especialidad()
    {
        return $this->belongsTo('App\Especialidad', 'ESPECIALIDAD', 'IDS');
    }

    public function afiliado()
    {
        return $this->belongsTo('App\Afiliado', '', 'IDS');
    }
}
