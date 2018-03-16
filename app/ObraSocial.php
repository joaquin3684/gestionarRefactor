<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObraSocial extends Model
{
    protected $primaryKey = 'ID';
    protected $table = 'obras_sociales';


    protected $fillable = [
        'NOMBRE'
    ];

    public function clinicas()
    {
        return $this->belongsToMany('App\Climed', 'Climed_obra_social', 'IDCLIMED', 'IDOBRASOCIAL');
    }

    public function afiliados()
    {
        return $this->hasMany('App\Afiliado', 'IDOBRASOCIAL', 'ID');
    }

    public function farmacias()
    {
        return $this->belongsToMany('App\Farmacia', 'Farmacia_obra_social', 'id_farmacia', 'id_obra_social');
    }
}
