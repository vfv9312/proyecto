<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\empleados>
 */
class EmpleadosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'id_persona' => \App\Models\personas::factory(),
            'comentario' => $this->faker->text(30),
            'rol_empleado' => $this->faker->jobTitle(),
            'fotografia' => $this->faker->imageUrl(640, 480, 'people'),

        ];
    }
}
