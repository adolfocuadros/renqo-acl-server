<?php

namespace App;

use Moloquent\Eloquent\Model;

class Sesion extends Model
{
    protected $collection = 'sesiones';

    protected $fillable = ['ip', 'expira'];

    protected $dates = ['expira'];

    public function usuario()
    {
        return $this->belongsTo(\App\Usuario::class);
    }
}
