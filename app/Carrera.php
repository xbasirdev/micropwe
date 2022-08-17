<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Egresado;
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

    public function egresado()
    {
        return $this->hasOne(Egresado::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}