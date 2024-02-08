<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\direcciones_clientes>
 */
class DireccionesClientesFactory extends Factory
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
            'id_direccion' => \App\Models\direcciones::factory(),
            'id_cliente' => \App\Models\clientes::factory()*/];
    }
}
