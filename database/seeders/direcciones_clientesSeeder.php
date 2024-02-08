<?php

namespace Database\Seeders;

use App\Models\direcciones_clientes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class direcciones_clientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        direcciones_clientes::create([
            'id_direccion' => '1',
            'id_cliente' => '1',
        ]);
        direcciones_clientes::create([
            'id_direccion' => '2',
            'id_cliente' => '1',
        ]);
        direcciones_clientes::create([
            'id_direccion' => '3',
            'id_cliente' => '2',
        ]);
        direcciones_clientes::create([
            'id_direccion' => '4',
            'id_cliente' => '3',
        ]);
        direcciones_clientes::create([
            'id_direccion' => '5',
            'id_cliente' => '4',
        ]);
        direcciones_clientes::create([
            'id_direccion' => '6',
            'id_cliente' => '5',
        ]);
        direcciones_clientes::create([
            'id_direccion' => '7',
            'id_cliente' => '6',
        ]);
        direcciones_clientes::create([
            'id_direccion' => '8',
            'id_cliente' => '7',
        ]);
        direcciones_clientes::create([
            'id_direccion' => '9',
            'id_cliente' => '8',
        ]);
        direcciones_clientes::create([
            'id_direccion' => '10',
            'id_cliente' => '9',
        ]);
        direcciones_clientes::create([
            'id_direccion' => '11',
            'id_cliente' => '10',
        ]);
        direcciones_clientes::create([
            'id_direccion' => '12',
            'id_cliente' => '11',
        ]);
        direcciones_clientes::create([
            'id_direccion' => '13',
            'id_cliente' => '12',
        ]);
        direcciones_clientes::create([
            'id_direccion' => '14',
            'id_cliente' => '13',
        ]);
        direcciones_clientes::create([
            'id_direccion' => '16',
            'id_cliente' => '15',
        ]);
        direcciones_clientes::create([
            'id_direccion' => '17',
            'id_cliente' => '16',
        ]);
        direcciones_clientes::create([
            'id_direccion' => '18',
            'id_cliente' => '17',
        ]);
        direcciones_clientes::create([
            'id_direccion' => '19',
            'id_cliente' => '18',
        ]);
        direcciones_clientes::create([
            'id_direccion' => '21',
            'id_cliente' => '20',
        ]);
        direcciones_clientes::create([
            'id_direccion' => '22',
            'id_cliente' => '21'
        ]);
        direcciones_clientes::create([
            'id_direccion' => '23',
            'id_cliente' => '22'
        ]);
        direcciones_clientes::create([
            'id_direccion' => '24',
            'id_cliente' => '23'
        ]);
        direcciones_clientes::create([
            'id_direccion' => '25',
            'id_cliente' => '24',
        ]);
    }
}
