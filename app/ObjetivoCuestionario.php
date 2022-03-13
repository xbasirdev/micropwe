<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class objetivoCuestionario extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $table = "objetivo_cuestionario";
    protected $fillable = [
        'nombre', 'descripcion', 'intervalo'
    ];

}