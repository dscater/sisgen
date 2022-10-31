<?php

namespace Database\Factories;

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

        $puntuacion = $this->faker->numberBetween(1, 100);
        $habilidad = "EXPERTO";
        if ($puntuacion <= 25) {
            $habilidad = "PRINCIPIANTE";
        } elseif ($puntuacion <= 50) {
            $habilidad = "INTERMEDIO";
        } elseif ($puntuacion <= 75) {
            $habilidad = "MODERADO";
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
            'tipo' => $this->faker->randomElement(['SUPERVISOR', 'GUARDIA']),
            'puntuacion_habilidad' => $puntuacion,
            'habilidad' => $habilidad,
            'estado' => 'ACTIVO',
            'foto' => 'default.png',
            'fecha_registro' => date('Y-m-d'),
        ];
    }
}
