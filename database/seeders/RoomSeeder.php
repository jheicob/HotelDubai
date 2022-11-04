<?php

namespace Database\Seeders;

use App\Models\EstateType;
use App\Models\PartialCost;
use App\Models\PartialRates;
use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\RoomStatus;
use App\Models\RoomType;

class RoomSeeder extends Seeder
{
    private $cab = [
        'CS' => [
            ['name' => '104'],
            ['name' => '106'],
            ['name' => '108'],
            ['name' => '110'],
            ['name' => '116'],
            ['name' => '120'],
            ['name' => '122'],
            ['name' => '124'],
            ['name' => '126'],
            ['name' => '128'],
            ['name' => '201'],
            ['name' => '202'],
            ['name' => '203'],
            ['name' => '204'],
            ['name' => '205'],
            ['name' => '206'],
            ['name' => '207'],
            ['name' => '208'],
            ['name' => '209'],
            ['name' => '210'],
            ['name' => '211'],
            ['name' => '212'],
            ['name' => '213'],
            ['name' => '214'],
            ['name' => '215'],
            ['name' => '216'],
            ['name' => '301'],
            ['name' => '302'],
            ['name' => '303'],
            ['name' => '304'],
            ['name' => '305'],
            ['name' => '306'],
            ['name' => '307'],
            ['name' => '308'],
            ['name' => '309'],
            ['name' => '310'],
            ['name' => '311'],
            ['name' => '312'],
            ['name' => '313'],
            ['name' => '314'],
            ['name' => '315'],
            ['name' => '316']
        ],
        'CSP' => [
            ['name' => '102'],
            ['name' => '112'],
            ['name' => '114'],
            ['name' => '118']
        ],
        'PAL' => [
            ['name' => '103'],
            ['name' => '105'],
            ['name' => '107'],
            ['name' => '115'],
            ['name' => '117']
        ],
        'GAL' => [
            ['name' => '119'],
            ['name' => '121'],
            ['name' => '123'],
            ['name' => '125'],
            ['name' => '127']
        ],
        'GROOVIE' => [['name' => '101']],
        'ROJO' => [['name' => '113']],
        'AFR' => [['name' => '109']],
        'DUBAI' => [['name' => '111']],
    ];

    private $ed = [
        'JSU' => [
            ['name' => '1001'],
            ['name' => '1002'],
            ['name' => '1005'],
            ['name' => '1006'],
            ['name' => '1007'],
            ['name' => '1008'],
            ['name' => '2012'],
            ['name' => '3001'],
            ['name' => '3005'],
            ['name' => '3006'],
            ['name' => '3007'],
            ['name' => '3008'],
            ['name' => '3012'],
            ['name' => '4001'],
            ['name' => '4005'],
            ['name' => '4006'],
            ['name' => '4007'],
            ['name' => '4008'],
            ['name' => '4012'],
            ['name' => '4013']
        ],
        'JSUP' => [
            ['name' => '1003'],
            ['name' => '1111'],
            ['name' => '1112'],
            ['name' => '2001'],
            ['name' => '2002'],
            ['name' => '2003'],
            ['name' => '2005'],
            ['name' => '2006'],
            ['name' => '2007'],
            ['name' => '2008'],
            ['name' => '2010'],
            ['name' => '2011'],
            ['name' => '3002'],
            ['name' => '3003'],
            ['name' => '3010'],
            ['name' => '3011'],
            ['name' => '4002'],
            ['name' => '4003'],
            ['name' => '4010'],
            ['name' => '4011']
        ],
        'JSUDS' => [
            ['name' => '1009'],
            ['name' => '1010'],
            ['name' => '2009'],
            ['name' => '3009'],
            ['name' => '4009']
        ],
        'JSUDM' => [
            ['name' => '1004'],
            ['name' => '2004'],
            ['name' => '3004'],
            ['name' => '4004']
        ],
        'DUBAINC' => [['name' => '0001']],
        'DUBAIB' => [['name' =>  '0002']],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = RoomStatus::firstWhere('name', 'Disponible');
        $room_types = RoomType::all();
        $partial_cost = PartialCost::all();
        $estates = EstateType::all();
        $room_types->map(function ($type) use ($status, $estates, $partial_cost) {
            $elements = [];
            if (array_key_exists($type->name, $this->cab)) {
                $room_type_id = $type->id;
                $elements = $this->cab;
                $id_estate = $estates->where('name', 'Cabaña')->first();
            } else
            if (array_key_exists($type->name, $this->ed)) {
                $room_type_id = $type->id;
                $elements = $this->ed;
                $id_estate = $estates->where('name', 'Edificio')->first();
            } else {

                return;
            }

            foreach ($elements[$type->name] as $element) {
                $cost = $partial_cost->where("room_type_id", $type->id)->first();
                if ($cost == '') continue;
                Room::create([
                    'room_status_id' => $status->id,
                    'partial_cost_id' => $cost->id,
                    'estate_type_id' => $id_estate->id,
                    'description' => $element['name'],
                    'name' => $element['name'],
                ]);
            }
        });
    }
}
