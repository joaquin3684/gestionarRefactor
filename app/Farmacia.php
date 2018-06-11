<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Farmacia extends Model
{
    protected $primaryKey = 'ID';
    protected $table = 'Farmacias';
    public $timestamps = false;

    protected $fillable = [
        'NOMBRE', 'LOCALIDAD', 'latitude', 'longitude', 'TELEFONO', 'DIRECCION', 'ZONA'
    ];

    public function obrasSociales()
    {
        return $this->belongsToMany('App\ObraSocial', 'Farmacia_obra_social', 'id_farmacia', 'id_obra_social');
    }
}
