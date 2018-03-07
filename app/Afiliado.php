<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Afiliado extends Model
{
    protected $primaryKey = 'ID';
    protected $table = 'afiliados';

    protected $fillable = [
        'NOMBRE', 'APELLIDO', 'DNI', 'EMAIL', 'TELEFONO', 'CELULAR', 'DIRECCION', 'PISO', 'DEPARTAMENTO', 'NACIMIENTO', 'CUIL', 'OBS', 'GRUPOF', 'NAFILIADO', 'IDOBRASOCIAL'
    ];


    public function obraSocial()
    {
        return $this->belongsTo('App\ObraSocial', 'IDOBRASOCIAL', 'ID');
    }
}
