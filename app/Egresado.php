<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Carrera;

class Egresado extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $table = "egresado";
    protected $fillable = [
        'user_id','modo_registro', 'correo', 'periodo_egreso', 'fecha_egreso', 'notificacion', 'carrera_id'       
    ];

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }    

}