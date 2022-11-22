<?php

namespace Database\Seeders;

use App\Models\ExtraGuest;
use Illuminate\Database\Seeder;

class ExtraGuestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExtraGuest::create([
            'name' => 'Permitido',
            'rate' => 0
        ]);
    }
}
