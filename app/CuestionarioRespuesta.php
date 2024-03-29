<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CuestionarioPregunta;
use App\User;
use App\Verification;

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

    public function pregunta()
    {
        return $this->belongsTo(CuestionarioPregunta::class);
    }

    public function egresado()
    {
        return $this->belongsTo(User::class, "egresado_id", "id");
    }

    public function codigoVerificacion()
    {
        return $this->belongsTo(Verification::class, "codigoVerificacion_id", "id");
    }

}
