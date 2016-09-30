<?php

namespace App;

use Moloquent\Eloquent\Model;

class Sesion extends Model
{
    protected $collection = 'sesiones';

    protected $fillable = ['ip', 'expira'];

    protected $hidden = ['token'];

    protected $dates = ['expira'];

    public function scopeUserToken($query, $usuario, $token)
    {
        return $query
            ->where('usuario_id',$usuario)
            ->where('token',$token)
            ->first();
    }

    public function usuario()
    {
        return $this->belongsTo('Usuario');
    }
}
