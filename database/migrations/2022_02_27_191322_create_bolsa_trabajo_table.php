<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBolsaTrabajoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bolsa_trabajo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('nombre');
            $table->string('empresa');
            $table->string('vacantes')->nullable();
            $table->string('requisitos');
            $table->integer('carrera_id');
            $table->string('estatus');
            $table->date('fecha_publicacion')->nullable();
            $table->date('fecha_disponibilidad')->nullable();
            $table->string('contacto')->nullable();
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
        Schema::dropIfExists('bolsa_trabajo');
    }
}
