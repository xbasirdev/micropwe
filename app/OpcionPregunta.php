<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpcionPregunta extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $table = "cuestionario_pregunta";
    protected $fillable = [
        'nombre', 'esperada', 'pregunta_id'
    ];

}