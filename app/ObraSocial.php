<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObraSocial extends Model
{
    protected $primaryKey = 'ID';
    protected $table = 'Obras_sociales';
    public $timestamps = false;


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
}
