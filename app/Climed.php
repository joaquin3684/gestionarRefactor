<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Climed extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'IDCLI';
    protected $table = 'Climed';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'NOMBRE', 'DIRECCION', 'LOCALIDAD', 'ZONA', 'PARTICULAR', 'latitude', 'longitude', 'TELEFONO'
    ];

    public function especialidades()
    {
        return $this->belongsToMany('App\Especialidad', 'ClimedEsp', 'IDCLIMED', 'IDESP');
    }

    public function obrasSociales()
    {
        return $this->belongsToMany('App\ObraSocial', 'Climed_obra_social', 'IDCLIMED', 'IDOBRASOCIAL');
    }



}
