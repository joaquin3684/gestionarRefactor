<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Familiar extends Model
{
    protected $table = 'familiares';

    protected $fillable = [
        'nombre', 'apellido', 'dni', 'nacimiento', 'cuil', 'nafiliado', 'id_afiliado'
    ];
}
