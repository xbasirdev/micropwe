<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEgresadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egresado', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('modo_registro');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('cedula');
            $table->string('correo');
            $table->string('telefono')->nullable();
            $table->string('periodo_egreso');
            $table->date('fecha_egreso')->nullable();
            $table->boolean('notificacion')->default(false);
            $table->integer('carrera_id')->unsigned();
            $table->foreign('carrera_id')->references('id')->on('carrera');
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
        Schema::dropIfExists('egresado');
    }
}
