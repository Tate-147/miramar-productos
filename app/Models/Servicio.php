<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $fillable = [
        'codigo', 'nombre', 'descripcion', 'destino', 'fecha', 'costo'
    ];

    public function paquetes()
    {
        return $this->belongsToMany(Paquete::class, 'paquete_servicio');
    }   
}