<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BolsaTrabajo extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $table = "bolsa_trabajo";
    protected $fillable = [
        'nombre', 'user_id', 'empresa', 'vacantes', 'requisitos', 'carrera_id', 'fecha_publicacion', 'fecha_disponibilidad', 'contacto', 'estatus'
    ];

}