<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActoGrado extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $table = "acto_grado";
    protected $fillable = [
        'titulo', 'descripcion', 'fecha', 'user_id'
    ];

}
