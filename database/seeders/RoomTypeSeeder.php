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
            ['name' => 'Sencilla','description' => 'Sencilla'],
            ['name' => 'Doble','description' => 'Doble'],
        ],['name'],['description']);
    }
}
