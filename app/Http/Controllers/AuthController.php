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
        // Revisando que tenga las cabeceras
        if(!isset(getallheaders()['Auth-Token']) || !isset(getallheaders()['User-Id'])) {
            return response()->json(['error' => 'No Está autorizado'], 401);
        }

        $token = getallheaders()['Auth-Token'];
        $uid = getallheaders()['User-Id'];

        //Buscando la session en la DB
        $session = \App\Sesion::userToken($uid, $token);

        if(!$session->exists()) {
            return response()->json(['error' => 'No Está autorizado'], 401);
        }

        if(strtotime($session->expira) < strtotime('now')) {
            return response()->json(['error' => 'Su sesión a expirado'], 401);
        }
        
        $s = \App\Sesion::find($session->id);
        $s->expira = date('Y-m-d H:i:s', strtotime ( '+3 hour' , strtotime ('now') ));

        $s->saveOrFail();

        return response()->json(['status'=>true]);

    }

    private function newSession($request, $usuario)
    {
        try {
            $session = new \App\Sesion([
                'ip'            =>  $request->ip(),
                'expira'        =>  date('Y-m-d H:i:s', strtotime ( '+3 hour' , strtotime ('now') ))
            ]);
            $session->token = $this->genToken();
            $session->usuarios_id = $usuario->id;
            $session->saveOrFail();
        } catch (Exception $e) {
            return response()->json(['error',[
                'Hay un problema técnico al iniciar session, por favor contacte al administrador del sistema'
            ]], 500);
        }
        $usuarios_id = $session->usuarios_id;
        $token = $session->token;
        $expira = $session->expira;
        return response()->json(compact('usuarios_id', 'token', 'expira', 'usuario'),201);
    }

    private function genToken()
    {
        return bin2hex(random_bytes(32));
    }
}
