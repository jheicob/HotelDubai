<?php

namespace Database\Seeders;

use App\Models\ThemeType;
use Illuminate\Database\Seeder;

class ThemeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ThemeType::upsert([
            ['name' => 'Selva','description' => 'Selva'],
            ['name' => 'Playa','description' => 'Playa'],
        ],['name'],['description']);
    }
}
