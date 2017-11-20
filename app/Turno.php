<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    protected $primaryKey = 'IDT';
    public $timestamps = false;
    protected $table = 'Turnos';
    protected $fillable = [
        'IDSOLICITUD', 'FECHAT', 'HORAT', 'CONFIRMACION', 'MEDICOASIGNADO', 'MOTIVOT'
    ];

    public function climed()
    {
        return $this->belongsTo('App\Climed', 'MEDICOASIGNADO', 'IDCLI');
    }
}
