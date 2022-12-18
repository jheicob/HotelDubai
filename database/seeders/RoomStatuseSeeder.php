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
                'name' => 'Sucia',
                'description' => 'Sucia',
                'color' => '{
                "css": "background-color:rgba(239,174,77,1)",
                "mode": "solid",
                "color": {
                    "a": 1,
                    "b": 77,
                    "g": 174,
                    "r": 239
                }
                }'
            ],
            [
                'name' => 'Disponible',
                'description' => 'Disponible',
                'color' => '{"css": "background-color:rgba(22,160,133,1)", "mode": "solid", "color": {"a": 1, "b": 133, "g": 161, "r": 22}}'
            ],
            [
                'name' => 'Fuera de Servicio',
                'description' => 'Fuera de Servicio',
                'color' => '{"css": "background-color:rgba(123,125,177,1)", "mode": "solid", "color": {"a": 1, "b": 77, "g": 174, "r": 239}}'
            ],
            [
                'name' => 'Ocupada',
                'description' => 'Ocupada',
                'color' => '{"css": "background-color:rgba(218,83,79,1)", "mode": "solid", "color": {"a": 1, "b": 79, "g": 83, "r": 218}}'
            ],
            [
                'name' => 'Reservada',
                'description' => 'Reservada',
                'color' => '{"css": "background-color:rgba(118,183,79,1)", "mode": "solid", "color": {"a": 1, "b": 79, "g": 183, "r": 118}}'
            ],
        ], ['name'], ['description', 'color']);
    }
}
