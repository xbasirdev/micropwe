<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBolsaEgresadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bolsa_egresado', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('egresado_id')->unsigned();
            $table->foreign('egresado_id')->references('id')->on('users');
            $table->integer('bolsa_trabajo_id')->unsigned();
            $table->foreign('bolsa_trabajo_id')->references('id')->on('bolsa_trabajo');
            $table->string('estado');
            $table->date('fecha');
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
        Schema::dropIfExists('bolsa_egresado');
    }
}
