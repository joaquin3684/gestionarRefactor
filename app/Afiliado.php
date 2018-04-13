<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Afiliado extends Model
{
    protected $primaryKey = 'ID';
    protected $table = 'Afiliados';
    public $timestamps = false;

    protected $fillable = [
        'NOMBRE', 'APELLIDO', 'DNI', 'EMAIL', 'TELEFONO', 'CELULAR', 'DIRECCION', 'PISO', 'DEPARTAMENTO', 'NACIMIENTO', 'CUIL', 'GRUPOF', 'NAFILIADO', 'IDOBRASOCIAL', 'OBS', 'id_usuario', 'PLAN'
    ];


    public function obraSocial()
    {
        return $this->belongsTo('App\ObraSocial', 'IDOBRASOCIAL', 'ID');
    }

    public function usuario()
    {
        return $this->belongsTo('App\User', 'id_usuario', 'ID');
    }

    public function recomendaciones()
    {
        return $this->hasMany('App\Recomendacion', 'NRO', 'DNI');
    }

    public function familiares()
    {
        return $this->hasMany('App\Familiar', 'id_afiliado', 'DNI');
    }
}
