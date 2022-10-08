<?php

namespace Database\Seeders;

use App\Models\ShiftSystem;
use Illuminate\Database\Seeder;

class ShiftSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShiftSystem::upsert([
            ['name' => 'am','description' => 'am'],
            ['name' => 'pm','description' => 'pm'],
        ],['name'],['description']);
    }
}
