<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Climed extends Model
{
    protected $primaryKey = 'IDCLI';
    protected $table = 'climed';

    protected $fillable = [
        'NOMBRE', 'DIRECCION', 'LOCALIDAD', 'ZONA', 'PARTICULAR', 'latitude', 'longitude', 'TELEFONO'
    ];

    public function especialidades()
    {
        return $this->belongsToMany('App\Especialidad', 'climed_esp', 'IDCLIMED', 'IDESP');
    }

    public function obrasSociales()
    {
        return $this->belongsToMany('App\ObraSocial', 'climed_obra_social', 'IDOBRASOCIAL', 'IDCLIMED');
    }

}
