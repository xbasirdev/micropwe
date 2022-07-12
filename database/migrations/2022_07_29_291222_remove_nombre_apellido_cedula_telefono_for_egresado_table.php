<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveNombreApellidoCedulaTelefonoForEgresadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('egresado')) {
            Schema::table('egresado', function (Blueprint $table) {
                $table->dropColumn('nombres');
                $table->dropColumn('apellidos');
                $table->dropColumn('cedula');
                $table->dropColumn('telefono');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('egresado', function (Blueprint $table) {
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('cedula');
            $table->string('telefono');
        });
    }
}
