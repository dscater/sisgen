<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    use HasFactory;

    protected $fillable = [
        "generacion_id", 'puesto_vigilancia_id', 'fecha_registro',
    ];

    protected $with = ["puesto_vigilancia", "asignacion_personals.personal"];

    //RELACIONES
    public function asignacion_personals()
    {
        return $this->hasMany(AsignacionPersonal::class, 'asignacion_id');
    }

    public function puesto_vigilancia()
    {
        return $this->belongsTo(PuestoVigilancia::class, 'puesto_vigilancia_id');
    }
}
