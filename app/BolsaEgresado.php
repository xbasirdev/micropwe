<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BolsaEgresado extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $table = "bolsa_egresado";
    protected $fillable = [
        'egresado_id', 'bolsa_trabajo_id', 'estado', 'fecha'
    ];

}