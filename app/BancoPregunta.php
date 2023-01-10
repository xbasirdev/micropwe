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
        'banco_id', 'pregunta_id'
    ];

    public function banco()
    {
        return $this->belongsTo(Banco::class);
    }

    public function pregunta()
    {
        return $this->belongsTo(CuestionarioPregunta::class);
    }

}