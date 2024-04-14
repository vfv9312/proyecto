<?php

namespace Database\Seeders;

use App\Models\Info_tickets;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Info_ticketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Info_tickets::create([
            'ubicaciones' => '4a. Av. Norte Poniente No. 867 Col. Centro - C.P. 29000 Tuxtla Gutierrez, Chiapas',
            'telefono' => '(961) 61.115.44 extención de venta: 2',
            'whatsapp' => '(961) 24.017.18',
            'pagina_web' => 'https://www.ecotonerdelsureste.com'
        ]);
    }
}
