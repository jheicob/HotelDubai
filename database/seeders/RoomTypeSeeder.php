<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RoomType::upsert([
            ['name' => 'CS', 'description' => 'Classic Suite'],
            ['name' => 'CSP', 'description' => 'Classic Suite Plus'],
            ['name' => 'PAL', 'description' => 'Palacio'],
            ['name' => 'GAL', 'description' => 'Galactic'],
            ['name' => 'GROOVIE', 'description' => 'GROOVIE'],
            ['name' => 'ROJO', 'description' => 'Cuarto Rojo'],
            ['name' => 'AFR', 'description' => 'Cuarto Africano'],
            ['name' => 'DUBAID', 'description' => 'Dubai Deluxe'],
            ['name' => 'DUBAI', 'description' => 'P	Dubai Pareja'],
            ['name' => 'JSU', 'description' => 'Junior Suite'],
            ['name' => 'JSUP', 'description' => 'Junior Suite Plus'],
            ['name' => 'JSUDS', 'description' => 'Junior Suite Duplex sencilla'],
            ['name' => 'JSUDM', 'description' => 'Junior Suite Duplex Matrimonial '],
            ['name' => 'DUBAINC', 'description' => 'Dubai Night Club'],
            ['name' => 'DUBAIB', 'description' => 'Dubai Beach'],
        ], ['name'], ['description']);
    }
}
