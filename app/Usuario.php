<?php

namespace App;

use Moloquent\Eloquent\Model;

class Usuario extends Model
{
    protected $collection = 'usuarios';

    protected $fillable = ['nombre', 'usuario', 'persona_id'];

    protected $hidden = ['pass', 'permisos'];

    public function scopeUsuario($query, $usuario)
    {
        return $query
            ->where('usuario', $usuario)
            ->first();
    }
    
    public function sesiones()
    {
        return $this->hasMany('\App\Sesion');
    }
}
