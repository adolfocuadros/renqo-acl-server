<?php

namespace App\Http\Controllers;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = \App\Usuario::paginate(20);
        return response()->json($usuarios);
    }
}
