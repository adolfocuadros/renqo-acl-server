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
        DB::table('usuarios')->insert([
            'nombre'    => 'Admin',
            'usuario'      => 'admin',
            'pass'      => Hash::make('secreto'),
            'nivel'     => 100,
            'permisos'  => '*'
        ]);
    }
}