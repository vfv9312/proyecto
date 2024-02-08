<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\productos>
 */
class ProductosFactory extends Factory
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
            'nombre_comercial' => $this->faker->sentence(3),
            'color' => $this->faker->colorName(),
            'marca' => $this->faker->company(),
            'fotografia' => $this->faker->imageUrl()

        ];
    }
}
