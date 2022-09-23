<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;
    protected $fillable = [
        'personal_id', 'tipo', 'hora', 'fecha', 'fecha_registro',
    ];

    protected $with = ['personal'];

    public function personal()
    {
        return $this->belongsTo(Personal::class, 'personal_id');
    }
}
