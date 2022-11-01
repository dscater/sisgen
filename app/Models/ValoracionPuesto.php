<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValoracionPuesto extends Model
{
    use HasFactory;

    protected $fillable = [
        "cant_min_per_alto", "cant_max_per_alto", "cant_min_sup_alto", "cant_min_guar_alto", "cant_max_guar_alto",
        "cant_min_per_medio", "cant_max_per_medio", "cant_min_sup_medio", "cant_min_guar_medio", "cant_max_guar_medio",
        "cant_min_per_basico", "cant_max_per_basico", "cant_min_sup_basico", "cant_min_guar_basico", "cant_max_guar_basico",
    ];
}
