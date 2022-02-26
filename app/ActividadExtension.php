<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActividadExtension extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $table = "actividad_extension";
    protected $fillable = [
        'titulo', 'descripcion', 'tipo', 'carrera', 'periodo'
    ];

}