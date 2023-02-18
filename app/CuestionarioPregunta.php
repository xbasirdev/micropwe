<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuestionarioPregunta extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $table = "cuestionario_pregunta";
    protected $fillable = [
        'numPregunta', 'cuestionario_id', 'tipoPregunta_id', 'pregunta', 'preguntaBanco'
    ];

    public function respuesta()
    {
        return $this->hasOne(CuestionarioRespuesta::class);
    }

    public function cuestionario()
    {
        return $this->belongsTo(Cuestionario::class);
    }

}