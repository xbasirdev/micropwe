<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuestionarioPreguntaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuestionario_pregunta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numPregunta')->unsigned();
            $table->integer('cuestionario_id')->unsigned()->nullable();
            $table->integer('tipoPregunta_id')->unsigned();
            $table->foreign('cuestionario_id')->references('id')->on('cuestionario');
            $table->foreign('tipoPregunta_id')->references('id')->on('tipo_pregunta');
            $table->string('pregunta');
            $table->boolean('preguntaBanco')->default(false);
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
        Schema::dropIfExists('cuestionario_pregunta');
    }
}
