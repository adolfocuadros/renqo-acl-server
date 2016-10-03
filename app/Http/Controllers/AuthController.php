<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Mockery\CountValidator\Exception;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'usuario'   =>  'required|string|exists:usuarios,usuario',
            'pass'      =>  'required|string'
        ], [
            'usuario.exists'    =>  'El usuario no existe'
        ]);

        $usuario = \App\Usuario::usuario($request->get('usuario'));

        if(!Hash::check($request->get('pass'), $usuario->pass)) {
            return response()->json(['pass' => ['La contraseña no es válida']], 422);
        }

        return $this->newSession($request, $usuario);
    }

    public function logout()
    {
        if(!isset(getallheaders()['Auth-Token']) || !isset(getallheaders()['User-Id'])) {
            return response()->json(['error' => 'No Está autorizado'], 401);
        }

        $token = getallheaders()['Auth-Token'];
        $uid = getallheaders()['User-Id'];

        //Buscando la session en la DB
        $session = \App\Sesion::userToken($uid, $token);

        if(!$session->exists()) {
            return response()->json(['error' => 'No existe Token'], 200);
        }


        \App\Sesion::destroy($session->id);

        return response()->json(['status'=>true]);

    }

    public function checkSession(Request $request)
    {
        try {
            // Revisando que tenga las cabeceras
            if (!isset(getallheaders()['Auth-Token'])) {
                return response()->json(['error' => 'No Está autorizado'], 401);
            }

            $token = getallheaders()['Auth-Token'];

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
            return response()->json(['error'=>'Ha ocurrido un error'], 500);
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

    private function genToken()
    {
        return bin2hex(random_bytes(32));
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
