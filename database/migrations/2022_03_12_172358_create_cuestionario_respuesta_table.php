<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuestionarioRespuestaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuestionario_respuesta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pregunta_id')->unsigned();
            $table->integer('egresado_id')->unsigned();
            $table->integer('codigoVerificacion_id')->unsigned();
            $table->foreign('pregunta_id')->references('id')->on('cuestionario_pregunta');
            $table->integer('egresado_id');
            $table->foreign('codigoVerificacion_id')->references('id')->on('verificacion');
            $table->date('fecha');
            $table->string('respuesta');
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
        Schema::dropIfExists('cuestionario_respuesta');
    }
}
