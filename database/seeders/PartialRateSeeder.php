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
                'name'        => '4h',
                'description' => '4h'
            ],
            [
                'name'        => '6h',
                'description' => '6h'
            ],
            [
                'name'        => '8h',
                'description' => '8h'
            ],
        ],['name'],['description']);
    }
}
