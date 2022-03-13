<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $table = "verification";
    protected $fillable = [
        'codigo'
    ];

}