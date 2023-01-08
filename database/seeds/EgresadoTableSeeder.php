<?php

declare (strict_types = 1);

use Illuminate\Database\Seeder;
use App\Egresado;
use Carbon\Carbon;

class EgresadoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Egresado::firstOrCreate(["user_id" => '2'], [
            "user_id" => '2',
            "modo_registro" => 'Manual',
            "correo" =>"correoegresadopersonal@gmail.com",
            "periodo_egreso" => "2022-2",
            "fecha_egreso" => Carbon::now('UTC')->toDateTimeString(),
            "carrera_id" => "1",
            "notificacion" => true,
        ]);
    }
}
