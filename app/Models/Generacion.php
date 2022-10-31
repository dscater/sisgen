<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generacion extends Model
{
    use HasFactory;

    protected $fillable = ["fecha"];

    public function asignacions()
    {
        return $this->hasMany(Asignacion::class, 'generacion_id');
    }
}
