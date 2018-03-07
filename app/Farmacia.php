<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Farmacia extends Model
{
    protected $primaryKey = 'ID';
    protected $table = 'farmacias';

    protected $fillable = [
        'NOMBRE', 'LOCALIDAD', 'latitude', 'longitude', 'TELEFONO', 'DIRECCION'
    ];

}
