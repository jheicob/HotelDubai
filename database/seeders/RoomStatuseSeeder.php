<?php

namespace Database\Seeders;

use App\Models\RoomStatus;
use Illuminate\Database\Seeder;

class RoomStatuseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RoomStatus::upsert([
            ['name' => 'Limpiando','description' => 'Limpiando'],
            ['name' => 'Reparación','description' => 'Reparación'],
            ['name' => 'Ocupada','description' => 'Ocupada'],
            ['name' => 'Fuera de Servicio','description' => 'Fuera de Servicio'],
        ],['name'],['description']);
    }
}
