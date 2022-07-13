<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use Notifiable;

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