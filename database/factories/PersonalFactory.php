<?php

namespace Database\Factories;

use App\Models\ValoracionPersonal;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $valoracion_personal = ValoracionPersonal::first();
        if ($valoracion_personal) {
            $cant_min_experto = $valoracion_personal->cant_min_experto;
            $cant_max_moderado = $valoracion_personal->cant_max_moderado;
            $cant_max_intermedio = $valoracion_personal->cant_max_intermedio;
            $cant_max_principiante = $valoracion_personal->cant_max_principiante;
        } else {
            $cant_min_experto = 12;
            $cant_max_moderado = 11;
            $cant_max_intermedio = 7;
            $cant_max_principiante = 3;
        }

        $puntuacion = $this->faker->numberBetween(1, 100);
        $tipo = "SUPERVISOR";
        $habilidad = "EXPERTO";
        if ($puntuacion <= $cant_max_principiante) {
            $tipo = "GUARDIA";
            $habilidad = "PRINCIPIANTE";
        } elseif ($puntuacion <= $cant_max_intermedio) {
            $tipo = "GUARDIA";
            $habilidad = "INTERMEDIO";
        } elseif ($puntuacion <= $cant_max_moderado) {
            $tipo = "SUPERVISOR";
            $habilidad = "MODERADO";
        } else {
            $tipo = "SUPERVISOR";
            $habilidad = "EXPERTO";
        }

        return [
            'nombre' => mb_strtoupper($this->faker->unique()->name()),
            'paterno' => mb_strtoupper($this->faker->lastName()),
            'materno' => '',
            'ci' => $this->faker->unique()->randomNumber(6),
            'ci_exp' => $this->faker->randomElement(['LP', 'CB', 'SC', 'OR', 'PT', 'CH', 'TJ', 'PD', 'BN', 'OTRO']),
            'fecha_nacimiento' => $this->faker->dateTimeBetween('1999-01-01', '2003-12-31'),
            'estatura' => $this->faker->randomFloat(2, 1.65, 1.9),
            'peso' => $this->faker->numberBetween(70, 90),
            'nacionalidad' => 'BOLIVIANO',
            'dir' => mb_strtoupper($this->faker->paragraph(1)),
            'correo' => $this->faker->unique()->safeEmail(),
            'fono' => $this->faker->phoneNumber(),
            'cel' => $this->faker->phoneNumber(),
            'tipo' => $tipo,
            'puntuacion_habilidad' => $puntuacion,
            'habilidad' => $habilidad,
            'estado' => 'ACTIVO',
            'foto' => 'default.png',
            'fecha_registro' => date('Y-m-d'),
        ];
    }
}
