<?php

namespace Database\Seeders;

use App\Models\SystemTime;
use Illuminate\Database\Seeder;

class ShiftTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SystemTime::upsert([
            ['name' => '08:30','description' => '08:30'],
            ['name' => '10:30','description' => '10:30'],
        ],['name'],['description']);
    }
}
