<?php

declare (strict_types = 1);

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(['cedula' => "V-1111111"], [
            'id'=>1,
            'nombres' =>"admin",
            'apellidos' =>"admin",
            'cedula' =>"v-1111111",
            'telefono' =>"042411111111",
            "correo"=>"admin@gmail.com",
        ]);

        User::firstOrCreate(['cedula' => "V-2222222"], [
            'id'=>2,
            'nombres' =>"egresado",
            'apellidos' =>"egresado",
            'cedula' =>"v-2222222",
            'telefono' =>"042422222222",
            "correo"=>"egresado@gmail.com",
        ]);
    }
}
