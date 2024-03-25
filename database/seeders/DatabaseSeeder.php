<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Cancelaciones;
use App\Models\Catalago_ubicaciones;
use App\Models\direcciones_clientes;
use App\Models\precios_productos;
use App\Models\precios_servicios;
use App\Models\Roles;
use App\Models\Tipo;
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
        $this->call([
            Catalago_ubicacionesSeeder::class,
            MarcaSeeder::class,
            TipoSeeder::class,
            RolesSeeder::class,
            ColorSeeder::class,
            ModoSeeder::class,
            CancelacionesSeeder::class,
            ProductosSeeder::class,
            precios_productosSeeder::class,
        ]);

        //\App\Models\personas::factory(6)->create();
        \App\Models\empleados::factory(5)->create();
        \App\Models\clientes::factory(10)->create();
        \App\Models\User::factory(1)->create();
        /*
        \App\Models\direcciones::factory(30)->create();
        \App\Models\usuarios::factory(2)->create();
        \App\Models\productos::factory(10)->create();
        \App\Models\ventas::factory(15)->create();
*/


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
