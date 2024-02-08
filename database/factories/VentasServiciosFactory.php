<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ventas_servicios>
 */
class VentasServiciosFactory extends Factory
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
            'id_precio_servicio' => \App\Models\precios_servicios::factory(),
            'id_venta' => \App\Models\ventas::factory(),
            'cantidad' => $this->faker->numberBetween(1, 30),
            'descipcion' => $this->faker->text(),*/];
    }
}
