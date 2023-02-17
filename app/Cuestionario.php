<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CuestionarioPregunta;

class Cuestionario extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $table = "cuestionario";
    protected $fillable = [
        'nombre', 'user_id', 'descripcion', 'tipo', 'privacidad', 'fecha_inicio', 'fecha_fin',
    ];
    public function preguntas()
    {
        return $this->hasOne(CuestionarioPregunta::class);
    }

}