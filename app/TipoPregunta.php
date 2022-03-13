<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoPregunta extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $table = "tipo_pregunta";
    protected $fillable = [
        'nombre', 'descripcion'
    ];

}