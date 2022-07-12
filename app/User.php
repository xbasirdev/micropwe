<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $table = "users";
    protected $fillable = [
        'nombres', 'apellidos', 'cedula', 'telefono', "correo", "user_id"
    ];

}