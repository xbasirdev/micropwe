<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BancoPregunta extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $table = "banco_pregunta";
    protected $fillable = [
        'nombre', 'user_id', 'estado'
    ];

}