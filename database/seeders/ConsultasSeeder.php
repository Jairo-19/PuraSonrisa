<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Consulta;

class ConsultasSeeder extends Seeder
{
    public function run(): void
    {
        Consulta::create(['nombre' => 'Consulta Rosa',     'color' => '#cc0247', 'activa' => true]);
        Consulta::create(['nombre' => 'Consulta Azul',     'color' => '#08beff', 'activa' => true]);
        Consulta::create(['nombre' => 'Consulta Amarilla', 'color' => '#f59e0b', 'activa' => true]);
    }
}
