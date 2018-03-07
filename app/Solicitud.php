<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $primaryKey = 'IDS';
    protected $table = 'solicitudes';
    protected $fillable = [
        'MEDICO', 'FECHAS', 'ESTADO', 'ASIGNADO', 'IDAFILIADO', 'IDCLIMED', 'MOTIVO', 'ESPECIALIDAD', 'TIPO', 'FOTO', 'REVISADO', 'OBS'
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
        return $this->belongsTo('App\Afiliado', 'IDAFILIADO', 'ID');
    }
}
