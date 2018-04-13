<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    protected $primaryKey = 'IDESPECIALIDAD';
    protected $table = 'Especialidad';
    public $timestamps = false;

    protected $fillable = [
        'NOMBRE', 'ESTUDIO',
    ];

    public function clinicas()
    {
        return $this->belongsToMany('App\Climed', 'ClimedEsp', 'IDESP', 'IDCLIMED');
    }
}
