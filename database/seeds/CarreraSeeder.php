<?php

declare (strict_types = 1);

use Illuminate\Database\Seeder;
use App\Carrera;

class CarreraTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Carrera::firstOrCreate([
            'id'=>1,
            'nombre' =>"Ingenieria informatica",
            'user_id' =>"1",
            'estado' =>"1",
        ]);

        Carrera::firstOrCreate([
            'id'=>2,
            'nombre' =>"Ingenieria industrial",
            'user_id' =>"1",
            'estado' =>"1",
        ]);
    }
}
