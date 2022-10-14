<?php

namespace Database\Seeders;

use App\Models\PartialCost;
use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\RoomStatus;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = RoomStatus::firstWhere('name','Disponible');
        $partialCost = PartialCost::factory(6)->create();

        $init = 0;
        for($i=0; $i <= 60 ; $i ++){
            $i_partial = rand(0,5);
            $name = $init.$i;
            Room::create([
                'room_status_id' => $status->id,
                'partial_cost_id' => $partialCost[$i_partial]->id,
                'description' => 'Nueva habitación',
                'name' => $name
            ]);
            $init++;
        }
    }
}
