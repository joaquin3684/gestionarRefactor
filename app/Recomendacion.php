<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recomendacion extends Model
{
    protected $primaryKey = 'ID';

    protected $table = 'Recomendaciones';
    protected $fillable = [
        'NOMBRE', 'APELLIDO', 'NRO', 'FECHA', 'CONTACTADO', 'COMENTARIO', 'DNIAFILIADO'
    ];
    public $timestamps = false;


    public function afiliado()
    {
        return $this->belongsTo('App\Afiliado', 'DNIAFILIADO', 'DNI');
    }
}
