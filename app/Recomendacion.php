<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recomendacion extends Model
{
    protected $primaryKey = 'ID';

    protected $table = 'recomendaciones';
    protected $fillable = [
        'NOMBRE', 'APELLIDO', 'NRO', 'FECHA', 'CONTACTADO', 'COMENTARIO'
    ];

}
