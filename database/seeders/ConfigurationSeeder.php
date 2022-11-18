<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Configuration::create([
            'fiscal_machine_serial' => 'ASD-123',
            'env'           => 'SV',
            'exchange_rate' =>'8.5',
            'warning_time' =>'00:15:00',
            'cancel_time'  =>'00:15:00',
            'color_warning_time' => '{"mode":"solid","color":{"r":228,"g":210,"b":11,"a":1},"css":"background-color:rgba(228,210,11,1)"}',
            'color_past_time' => '{"mode":"solid","color":{"r":112,"g":43,"b":230,"a":1},"css":"background-color:rgba(112,43,230,1)"}'
        ]);
    }
}
