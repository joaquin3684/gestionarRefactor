<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Afiliado extends Model
{
    protected $primaryKey = 'ID';
    protected $table = 'Afiliados';
    public $timestamps = false;

    protected $fillable = [
        'NOMBRE', 'APELLIDO', 'DNI', 'EMAIL', 'TELEFONO', 'CELULAR', 'DIRECCION', 'PISO', 'DEPARTAMENTO', 'NACIMIENTO', 'CUIL', 'GRUPOF', 'NAFILIADO', 'IDOBRASOCIAL', 'OBS'
    ];


    public function obraSocial()
    {
        return $this->belongsTo('App\ObraSocial', 'IDOBRASOCIAL', 'ID');
    }

    public function usuario()
    {
        return $this->belongsTo('App\User', 'id_usuario', 'ID');
    }
}
