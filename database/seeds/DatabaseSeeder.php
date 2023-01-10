<?php

declare (strict_types = 1);

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CarreraTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(EgresadoTableSeeder::class);
        $this->call(TipoPreguntaTableSeeder::class);
    }
}
