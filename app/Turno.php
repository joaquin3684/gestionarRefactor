<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    protected $primaryKey = 'IDT';
    protected $table = 'Turnos';
    public $timestamps = false;

    protected $fillable = [
        'IDSOLICITUD', 'FECHAT', 'HORAT', 'CONFIRMACION', 'MEDICOASIGNADO', 'MOTIVOT', 'FECHACREACION', 'OBS'
    ];


}
