<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Traits\ImportTrait;
use App\Carrera;
use App\Egresado;

class User extends Model
{
    use Notifiable, ImportTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $table = "users";
    protected $fillable = [
        'id','nombres', 'apellidos', 'cedula', 'telefono', "correo", "user_id"
    ];

    public function carrera()
    {
        return $this->hasOne(Carrera::class);
    }

    public function egresado()
    {
        return $this->hasOne(Egresado::class);
    }
}