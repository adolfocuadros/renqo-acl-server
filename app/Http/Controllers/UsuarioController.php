<?php

namespace App\Http\Controllers;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = \App\Usuario::all();
        return response()->json($usuarios);
    }
}
