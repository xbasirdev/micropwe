<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $table = "evento";
    protected $fillable = [
        'titulo', 'descripcion', 'fecha', 'lugar', 'carreras', 'imagen', 'user_id'
    ];

}