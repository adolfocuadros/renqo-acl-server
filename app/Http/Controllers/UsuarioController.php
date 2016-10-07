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
    
    public function searchUser(Request $request) {

        if($request->has('email')) {
            $request->merge([
                'usuario' => $request->get('email')
            ]);
        }

        $this->validate($request, [
            'usuario'   => 'required|string'
        ]);

        $usuario = \App\Usuario::where('usuario','=',$request->get('usuario'))->first();
        if(count($usuario) == 0) {
            abort(404, 'No existe usuario');
        }

        //$usuario->setAttribute('password', $usuario->pass);

        return response()->json($usuario);
    }
}
