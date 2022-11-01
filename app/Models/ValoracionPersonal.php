<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValoracionPersonal extends Model
{
    use HasFactory;

    protected $fillable = [
        "cant_min_experto", "cant_max_experto", "cant_min_moderado", "cant_max_moderado",
        "cant_min_intermedio", "cant_max_intermedio", "cant_min_principiante", "cant_max_principiante",
    ];
}
