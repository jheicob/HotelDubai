<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TransferRoomTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /**
     * @test
     */
    public function transferRoom()
    {
        $user = User::find(1);
        $room_origin  = \App\Models\Room::where('room_status_id', 4)->first();
        $room_destiny = \App\Models\Room::where('room_status_id', 2)->first();

        $response = $this->actingAs($user)->postJson(route('transfer.room', [
            'room_origin' =>  $room_origin->id,
            'room_destiny' => $room_destiny->id,
            'motive'          => $type = $this->faker->randomElement(['Reparación', 'Inconformidad']),
            'observation'   => $obs = $this->faker->text()
        ]));

        $response->assertOk();

        if ($type == 'Reparación') {
            $repair = \App\Models\Repair::first();


            $this->assertEquals($room_origin->id, $repair->room_id);
            $this->assertEquals($user->id, $repair->report_user);
            $this->assertEquals($obs, $repair->description);

            $room_origin->refresh();
            $room_destiny->refresh();
            $this->assertEquals(3, $room_origin->room_status_id); // habitacion origen pasa a estado en mantenimiento
        } else
        if ($type == 'Inconformidad') {
            $this->assertEquals(2, $room_origin->room_status_id); // habitacion origen pasa a estado en mantenimiento
        }
        $this->assertEquals(4, $room_destiny->room_status_id); // habitacion destino para a estado ocuapada
        $transfer = \App\Models\TransferRoom::first();
        $this->assertEquals($room_destiny->id, $transfer->room_destiny);
        $this->assertEquals($room_origin->id, $transfer->room_origin);
        $this->assertEquals($type, $transfer->motive);
        $this->assertEquals($obs, $transfer->observation);
    }
}
