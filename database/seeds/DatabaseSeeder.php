<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::collection('usuarios')->insert(
            [
                'nombre'    => 'Admin',
                'usuario'   => 'admin',
                'pass'      => Hash::make('secreto'),
                'nivel'     => 100,
                'permisos'  => '*'
            ]
        );

        DB::collection('usuarios')->insert(
            [
                'nombre'    => 'Usuario 1',
                'usuario'   => 'user1',
                'pass'      => Hash::make('secreto'),
                'nivel'     => 1,
                'permisos'  => ['directorio.*', 'rrhh.*']
            ]
        );
    }
}