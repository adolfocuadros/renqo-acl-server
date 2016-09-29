<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';

    protected $fillable = ['nombre', 'usuario', 'persona_id'];

    protected $hidden = ['pass'];

    public function scopeUsuario($query, $usuario)
    {
        return $query
            ->where('usuario', $usuario)
            ->first();
    }
}
