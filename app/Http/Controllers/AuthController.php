<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Mockery\CountValidator\Exception;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if($request->has('email') && $request->has('password')) {
            $request->merge([
                'usuario'=>$request->get('email'),
                'pass'=>$request->get('password')
            ]);
        }
        
        $this->validate($request, [
            'usuario'   =>  'required|string|exists:usuarios,usuario',
            'pass'      =>  'required|string'
        ], [
            'usuario.exists'    =>  'El usuario no existe'
        ]);

        $usuario = \App\Usuario::usuario($request->get('usuario'));
        $usuario->makeVisible('permisos');

        if(!Hash::check($request->get('pass'), $usuario->pass)) {
            return response()->json(['pass' => ['La contraseña no es válida']], 422);
        }

        return $this->newSession($request, $usuario);
    }

    public function logout(Request $request)
    {
        if(!$request->hasHeader('Auth-Token')) {
            return response()->json(['error' => 'No Está autorizado'], 401);
        }

        $token = $request->header('Auth-Token');

        //Buscando la session en la DB
        $session = \App\Sesion::find($token);

        if(count($session)==0) {
            return response()->json(['error' => 'No existe Token'], 404);
        }

        \App\Sesion::destroy($session->id);

        return response()->json(['status'=>true]);
    }

    public function checkAcl(Request $request)
    {
        try {
            // Revisando que tenga las cabeceras
            if (!$request->hasHeader('Auth-Token')) {
                return response()->json(['error' => 'No Está autorizado'], 401);
            }

            $token = $request->header('Auth-Token');

            //Buscando la session en la DB
            $session = \App\Sesion::find($token);

            if (count($session) == 0) {
                return response()->json(['error' => 'No Está autorizado'], 401);
            }

            if ($session->expira->timestamp < strtotime('now')) {
                \App\Sesion::destroy($session->id);
                return response()->json(['error' => 'Su sesión a expirado'], 401);
            }

            $session->expira = date('Y-m-d H:i:s', strtotime('+3 hour', strtotime('now')));

            $session->save();

            if (!$request->has('permission')) {
                return response()->json(['error' => 'No tiene los permisos suficientes.'], 401);
            }
            if (!$this->checkPermission($session, $request->get('permission'))) {
                return response()->json(['error' => 'No tiene los permisos suficientes.'], 401);
            }
        } catch(\Exception $e) {
            return response()->json(['error'=>'Ha ocurrido un error en momento de ejecución'], 500);
        }
        return response()->json(['status'=>true]);

    }

    private function newSession($request, $usuario)
    {
        try {
            $session = new \App\Sesion([
                'ip'            =>  $request->ip(),
                'expira'        =>  date('Y-m-d H:i:s', strtotime ( '+3 hour' , strtotime ('now') ))
            ]);

            $usuario->sesiones()->save($session);
        } catch (Exception $e) {
            return response()->json(['error',[
                'Hay un problema técnico al iniciar session, por favor contacte al administrador del sistema'
            ]], 500);
        }
        $token = $session->id;
        $expira = $session->expira;
        return response()->json(compact('token', 'expira', 'usuario'), 201);
    }

    private function checkPermission($session, $permission)
    {
        $usuario_permisos = $session->usuario->permisos;

        if(!is_array($usuario_permisos) && $usuario_permisos == '*') {
            return true;
        }

        $app_permisos = explode('.',$permission);
        $niveles = count($app_permisos);

        foreach ($usuario_permisos as $permiso) {
            for($i = 0; $i < $niveles; $i++) {
                if($permiso == $app_permisos[$i].'.*' || $permiso == $app_permisos[$i]) {
                    return true;
                }
            }
        }

        return false;
    }
}
