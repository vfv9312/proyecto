<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\servicios>
 */
class ServiciosFactory extends Factory
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
            'tipo_de_proyecto' => $this->faker->sentence(),
            'id_venta' => $this->faker->numberBetween(1, 4),
            'descripcion' => $this->faker->text(30),
            'modelo' => $this->faker->sentence(),
            'color' => $this->faker->safeColorName(),
            'cantidad' => $this->faker->numberBetween(1, 100),
            'precio_unitario' => $this->faker->randomFloat(2, 1, 20),
            'estatus' => 1
        ];
    }
}
