<?php

namespace Database\Seeders;

use App\Models\PartialCost;
use App\Models\RoomType;
use Illuminate\Database\Seeder;

class PartialCostSeeder extends Seeder
{
    private $const = [
        'CS' => [
            ['partial_min' => '6h', 'rate' => 298],
            ['partial_min' => '8h', 'rate' => 298],
            ['partial_min' => '12h', 'rate' => 596],
            ['partial_min' => '16h', 'rate' => 596],
            ['partial_min' => '18h', 'rate' => 894],
            ['partial_min' => '24h', 'rate' => 894],
        ],
        'CSP' => [
            ['partial_min' => '6h', 'rate' => 383],
            ['partial_min' => '8h', 'rate' => 383],
            ['partial_min' => '12h', 'rate' => 766],
            ['partial_min' => '16h', 'rate' => 766],
            ['partial_min' => '18h', 'rate' => 1149],
            ['partial_min' => '24h', 'rate' => 1149],
        ],
        'PAL' => [
            ['partial_min' => '6h', 'rate' => 553],
            ['partial_min' => '8h', 'rate' => 553],
            ['partial_min' => '12h', 'rate' => 1106],
            ['partial_min' => '16h', 'rate' => 1106],
            ['partial_min' => '18h', 'rate' => 1659],
            ['partial_min' => '24h', 'rate' => 1659]
        ],
        'GAL' => [
            ['partial_min' => '6h', 'rate' => 554],
            ['partial_min' => '8h', 'rate' => 554],
            ['partial_min' => '12h', 'rate' => 1108],
            ['partial_min' => '16h', 'rate' => 1108],
            ['partial_min' => '18h', 'rate' => 1662],
            ['partial_min' => '24h', 'rate' => 1662]
        ],
        'GROOVIE' => [
            ['partial_min' => '6h', 'rate' => 555],
            ['partial_min' => '8h', 'rate' => 555],
            ['partial_min' => '12h', 'rate' => 1110],
            ['partial_min' => '16h', 'rate' => 1110],
            ['partial_min' => '18h', 'rate' => 1665],
            ['partial_min' => '24h', 'rate' => 1665]
        ],
        'ROJO' => [
            ['partial_min' => '6h', 'rate' => 556],
            ['partial_min' => '8h', 'rate' => 556],
            ['partial_min' => '12h', 'rate' => 1112],
            ['partial_min' => '16h', 'rate' => 1112],
            ['partial_min' => '18h', 'rate' => 1668],
            ['partial_min' => '24h', 'rate' => 1668]
        ],
        'AFR' => [
            ['partial_min' => '6h', 'rate' => 557],
            ['partial_min' => '8h', 'rate' => 557],
            ['partial_min' => '12h', 'rate' => 1114],
            ['partial_min' => '16h', 'rate' => 1114],
            ['partial_min' => '18h', 'rate' => 1671],
            ['partial_min' => '24h', 'rate' => 1671]
        ],
        'DUBAID' => [
            ['partial_min' => '6h', 'rate' => 638],
            ['partial_min' => '8h', 'rate' => 638],
            ['partial_min' => '12h', 'rate' => 1276],
            ['partial_min' => '16h', 'rate' => 1276],
            ['partial_min' => '18h', 'rate' => 1914],
            ['partial_min' => '24h', 'rate' => 1914]
        ],
        'DUBAI P' => [
            ['partial_min' => '8h', 'rate' => 553],
            ['partial_min' => '16h', 'rate' => 1106],
            ['partial_min' => '24h', 'rate' => 1659]
        ],
        'JSU' => [
            ['partial_min' => '8h', 'rate' => 298],
            ['partial_min' => '16h', 'rate' => 596],
            ['partial_min' => '24h', 'rate' => 894]
        ],
        'JSUP' => [
            ['partial_min' => '8h', 'rate' => 383],
            ['partial_min' => '16h', 'rate' => 766],
            ['partial_min' => '24h', 'rate' => 1149]
        ],
        'JSUDS' => [
            ['partial_min' => '8h', 'rate' => 384],
            ['partial_min' => '16h', 'rate' => 768],
            ['partial_min' => '24h', 'rate' => 1152]
        ],
        'JSUDM' => [
            ['partial_min' => '8h', 'rate' => 385],
            ['partial_min' => '16h', 'rate' => 770],
            ['partial_min' => '24h', 'rate' => 1155]
        ],
        'DUBAINC' => [
            ['partial_min' => '8h', 'rate' => 2975],
            ['partial_min' => '16h', 'rate' => 5950],
            ['partial_min' => '24h', 'rate' => 8925]
        ],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $room_types = \App\Models\RoomType::all();

        $partials = \App\Models\PartialRates::all();

        $room_types->map(function ($type) use ($partials) {

            if (!array_key_exists($type->name, $this->const)) {
                return;
            }
            foreach ($this->const[$type->name] as $item) {
                $partial_id = $partials->where('name', $item['partial_min'])->first();
                if ($partial_id == '') continue;
                PartialCost::create([
                    "room_type_id" => $type->id,
                    "partial_rates_id" => $partial_id->id,
                    "rate" => $item['rate'],
                ]);
            }
        });
    }
}
