<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuestionarioRespuesta extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $table = "cuestionario_respuesta";
    protected $fillable = [
        'pregunta_id', 'egresado_id', 'codigoVerificacion_id', 'fecha', 'respuesta'
    ];

}