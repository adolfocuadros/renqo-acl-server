<?php

namespace App\Http\Controllers;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function testMongo()
    {
        /*$prueba = \App\Usuario::create([
            'nombre'    => 'Super Admin',
            'usuario'   => 'admin',
            'pass'      => 'cualquiercosa',
            'nivel'     => 100
        ]);*/
        $usuario = \App\Usuario::find('57ee841d58586ba8d1007311');
        $usuario->sesiones()->create([
            'token' => 'un token',
            'ip'    => 'una IP',
            'expira'=> 'expira'
        ]);
        return response()->json($usuario);
    }
}
