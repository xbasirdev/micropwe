<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjetivoCuestionarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objetivo_cuestionario', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('carrera_id')->unsigned();
            $table->foreign('carrera_id')->references('id')->on('carrera');
            $table->integer('cuestionario_id')->unsigned();
            $table->foreign('cuestionario_id')->references('id')->on('cuestionario');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('objetivo_cuestionario');
    }
}
