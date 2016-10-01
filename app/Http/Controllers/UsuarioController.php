<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = \App\Usuario::paginate(20);
        return response()->json($usuarios);
    }

    public function store(Request $request)
    {
        sanitize_upper_string($request, ['nombre']);
        $this->validate($request, [
            'nombre'    => 'required|string_space',
            'usuario'   => 'required|nick|unique:usuarios',
            'pass'      => 'required|string',
            'nivel'     => 'required|numeric',
            'permisos'  => 'required|array'
        ],[
            'nick'  => 'El usuario solo puede tener letras y numeros'
        ]);
        
        $usuario = new \App\Usuario($request->input());
        $usuario->pass = Hash::make($request->get('pass'));
        $usuario->save();

        return response()->json($usuario);
    }
}
