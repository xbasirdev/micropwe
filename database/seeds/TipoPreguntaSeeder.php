<?php

declare (strict_types = 1);

use Illuminate\Database\Seeder;
use App\TipoPregunta;

class TipoPreguntaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoPregunta::firstOrCreate([
            'nombre' =>"texto",
            'descripcion' =>"Respuesta de texto",
        ]);
        
        TipoPregunta::firstOrCreate([
            'nombre' =>"multiple",
            'descripcion' =>"Seleccion Multiple",
        ]);

        TipoPregunta::firstOrCreate([
            'nombre' =>"seleccion",
            'descripcion' =>"Seleccion simple",
        ]);

        TipoPregunta::firstOrCreate([
            'nombre' =>"numerica",
            'descripcion' =>"Numerica",
        ]);

        TipoPregunta::firstOrCreate([
            'nombre' =>"rango",
            'descripcion' =>"Rango de 1 a 10",
        ]);
    }
}
