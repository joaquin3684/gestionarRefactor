<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Afiliado extends Model
{
    protected $primaryKey = 'ID';
    protected $table = 'Afiliados';
    protected $fillable = [
        'NOMBRE', 'APELLIDO', 'DNI', 'EMAIL', 'TELEFONO', 'CELULAR', 'DIRECCION', 'PISO', 'DEPARTAMENTO', 'NACIMIENTO', 'CUIL', 'OBS', 'GRUPOF', 'NAFILIADO'
    ];

}
