<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\personas>
 */
class PersonasFactory extends Factory
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
            'nombre' => $this->faker->firstName(),
            'apellido' => $this->faker->lastName(),
            'telefono' => $this->faker->phoneNumber(),
            'fecha_nacimiento' => $this->faker->dateTimeBetween('-80 years', '-18 years'),
            'email' => $this->faker->unique()->safeEmail()
        ];
    }
}
