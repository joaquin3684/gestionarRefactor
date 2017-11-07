<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Climed extends Model
{
    protected $primaryKey = 'IDCLI';
    protected $table = 'Climed';
    protected $fillable = [
        'NOMBRE', 'DIRECCION', 'LOCALIDAD', 'ZONA', 'PARTICULAR', 'latitude', 'longitude', 'TELEFONO'
    ];

    public function especialidades()
    {
        return $this->belongsToMany('App\Especialidad', 'ClimedEsp', 'IDCLIMED', 'IDESP');
    }

}
