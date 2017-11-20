<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recomendacion extends Model
{
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $table = 'Recomendaciones';
    protected $fillable = [
        'NOMBRE', 'APELLIDO', 'NRO', 'FECHA', 'CONTACTADO', 'COMENTARIO'
    ];

}
