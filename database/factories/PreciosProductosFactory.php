<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\precios_productos>
 */
class PreciosProductosFactory extends Factory
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
            /*
            'id_producto' => \App\Models\productos::factory(),
            'precio' => $this->faker->randomFloat(2, 1, 100),
            'descripcion' => $this->faker->text(30)
            */];
    }
}
