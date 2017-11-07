<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    protected $primaryKey = 'IDESPECIALIDAD';
    protected $table = 'Especialidad';

    protected $fillable = [
        'NOMBRE', 'ESTUDIO', 'LOCALIDAD', 'ZONA', 'PARTICULAR', 'latitude', 'longitude', 'TELEFONO'
    ];

    public function clinicas()
    {
        return $this->belongsToMany('App\Climed', 'ClimedEsp', 'IDESP', 'IDCLIMED');
    }
}
