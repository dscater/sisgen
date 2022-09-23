<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'paterno', 'materno', 'ci', 'ci_exp',
        'fecha_nacimiento', 'estatura', 'peso', 'nacionalidad', 'dir',
        'correo', 'fono', 'cel', 'tipo', 'habilidad', 'nivel', 'estado',
        'foto', 'fecha_registro',
    ];

    protected $appends = ['full_name', 'full_ci', 'path_image'];

    public function getFullNameAttribute()
    {
        return $this->nombre . ' ' . $this->paterno . ($this->materno != NULL && $this->materno != '' ? ' ' . $this->materno : '');
    }

    public function getFullCiAttribute()
    {
        return $this->ci . ' ' . $this->ci_exp;
    }

    public function getPathImageAttribute()
    {
        if ($this->foto && trim($this->foto) != "") {
            return asset('imgs/personal/' . $this->foto);
        }
        return asset('imgs/personal/default.png');
    }

    public function setEstaturaAttribute($value)
    {
        $this->attributes['estatura'] = number_format($value, 2);
    }

    public function setPesoAttribute($value)
    {
        $this->attributes['peso'] = number_format($value, 2);
    }
}
