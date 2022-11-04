<?php

namespace Database\Seeders;

use App\Models\PartialRates;
use Illuminate\Database\Seeder;

class PartialRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PartialRates::upsert([
            [
                'name'        => '6h',
                'description' => '6h'
            ],
            [
                'name'        => '8h',
                'description' => '8h'
            ],
            [
                'name'        => '12h',
                'description' => '12h'
            ],
            [
                'name'        => '16h',
                'description' => '16h'
            ],
            [
                'name'        => '18h',
                'description' => '18h'
            ],
            [
                'name'        => '24h',
                'description' => '24h'
            ],

        ], ['name'], ['description']);
    }
}
