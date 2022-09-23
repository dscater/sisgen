<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuestoVigilancia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'descripcion', 'personal', 'estado',
        'fecha_registro',
    ];

    public function asignacion()
    {
        return $this->hasOne(Asignacion::class, 'puesto_vigilancia_id');
    }

    public function materials()
    {
        return $this->hasMany(Material::class, 'puesto_vigilancia_id');
    }
}
