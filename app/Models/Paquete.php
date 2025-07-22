<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paquete extends Model
{
    protected $fillable = ['nombre', 'descripcion'];
    
    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'paquete_servicio');
    }   
}