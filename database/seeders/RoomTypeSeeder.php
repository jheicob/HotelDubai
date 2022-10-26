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
            ['name' => '6H', 'description' => '6H'],
            ['name' => '8H', 'description' => '8H'],
        ], ['name'], ['description']);
    }
}
