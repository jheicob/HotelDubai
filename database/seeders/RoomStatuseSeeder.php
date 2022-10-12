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
            [
                'name' => 'Limpiando',
                'description' => 'Limpiando',
                'color' => '{"css": "background-color:rgba(91,192,222,1)", "mode": "solid", "color": {"a": 1, "b": 222, "g": 192, "r": 91}}vvvvvv'
            ],
            [
                'name' => 'Disponible',
                'description' => 'Disponible',
                'color' => '{"css": "background-color:rgba(22,161,133,1)", "mode": "solid", "color": {"a": 1, "b": 133, "g": 161, "r": 22}}'
            ],
            [   'name' => 'Reparación',
                'description' => 'Reparación',
                'color' => '{"css": "background-color:rgba(239,174,77,1)", "mode": "solid", "color": {"a": 1, "b": 77, "g": 174, "r": 239}}'
            ],
            [   'name' => 'Ocupada',
                'description' => 'Ocupada',
                'color' => '{"css": "background-color:rgba(218,83,79,1)", "mode": "solid", "color": {"a": 1, "b": 79, "g": 83, "r": 218}}'
            ],
        ],['name'],['description']);
    }
}
