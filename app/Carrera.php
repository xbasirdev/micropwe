<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $table = "carrera";
    protected $fillable = [
        'nombre', 'user_id', 'estado'
    ];

}