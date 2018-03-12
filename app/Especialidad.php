<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    protected $primaryKey = 'IDESPECIALIDAD';
    protected $table = 'especialidades';


    protected $fillable = [
        'NOMBRE', 'ESTUDIO',
    ];

    public function clinicas()
    {
        return $this->belongsToMany('App\Climed', 'climed_esp', 'IDESP', 'IDCLIMED');
    }
}
