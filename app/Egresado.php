<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Egresado extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $table = "egresado";
    protected $fillable = [
        'user_id', 'nombres', 'apellidos', 'modo_registro', 'cedula', 'correo', 'telefono', 'periodo_egreso', 'fecha_egreso', 'notificacion', 'carrera_id'       
    ];

}