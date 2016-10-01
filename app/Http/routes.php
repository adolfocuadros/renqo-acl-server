<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});


# Genera la lista de usuarios del sistema
# GET /auth/usuarios
$app->get('usuarios', [
    'middleware' => ['check_session:auth.usuarios.index'],
    'uses' => 'UsuarioController@index'
]);

# Genera la lista de usuarios del sistema
# POST /auth/usuarios
$app->post('usuarios', [
    'middleware' => ['check_session:auth.usuarios.store'],
    'uses' => 'UsuarioController@store'
]);

# Autentifica a un usuario y crea nueva session
# POST /auth/login
$app->post('login', 'AuthController@login');

# Autentifica a un usuario y crea nueva session
# POST /auth/logout
$app->post('logout', 'AuthController@logout');

# Comprueba que la session es correcta
# POST /auth/session
$app->post('session', 'AuthController@checkSession');


$app->get('mongo', 'ExampleController@testMongo');
