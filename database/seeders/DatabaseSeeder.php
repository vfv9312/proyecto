<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\direcciones_clientes;
use App\Models\precios_productos;
use App\Models\precios_servicios;
use Faker\Factory;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\direcciones::factory(30)->create();
        \App\Models\personas::factory(30)->create();
        \App\Models\clientes::factory(20)->create();
        \App\Models\empleados::factory(10)->create();
        //\App\Models\direcciones_clientes::factory(15)->create();
        \App\Models\usuarios::factory(2)->create();
        //\App\Models\servicios::factory(3)->create();
        \App\Models\productos::factory(10)->create();
        \App\Models\ventas::factory(15)->create();
        //\App\Models\precios_productos::factory(10)->create();
        // \App\Models\precios_servicios::factory(3)->create();
        //\App\Models\ventas_productos::factory(15)->create();
        //\App\Models\ventas_servicios::factory(15)->create();

        $this->call([
            direcciones_clientesSeeder::class,
            precios_productosSeeder::class,
            ventas_productosSeeder::class,
            serviciosSeeder::class,
        ]);
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
