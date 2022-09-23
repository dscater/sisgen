<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo', 'nombre', 'descripcion', 'propietario',
        'puesto_vigilancia_id', 'fecha_registro',
    ];

    protected $with = ["puesto_vigilancia"];

    public function puesto_vigilancia()
    {
        return $this->belongsTo(PuestoVigilancia::class, 'puesto_vigilancia_id');
    }
}
