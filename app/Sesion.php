<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    protected $table = 'sesiones';

    protected $fillable = ['ip', 'expira'];

    protected $hidden = ['token'];

    public function scopeUserToken($query, $usuario, $token)
    {
        return $query
            ->where('usuarios_id',$usuario)
            ->where('token',$token)
            ->first();
    }
}
