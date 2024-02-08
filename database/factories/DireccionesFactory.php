<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\direcciones>
 */
class DireccionesFactory extends Factory
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
            'direccion' => $this->faker->address(),
            'cordenadas' => DB::raw("ST_GeomFromText('POINT(" . $this->faker->latitude . " " . $this->faker->longitude . ")')"),
            'referencia' => $this->faker->paragraph()
        ];
    }
}
