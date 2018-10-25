<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Especialidad extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'IDESPECIALIDAD';
    protected $table = 'Especialidad';
    protected $dates = ['deleted_at'];


    protected $fillable = [
        'NOMBRE', 'ESTUDIO', 'DIRECTO',
    ];

    public function clinicas()
    {
        return $this->belongsToMany('App\Climed', 'ClimedEsp', 'IDESP', 'IDCLIMED');
    }
}
