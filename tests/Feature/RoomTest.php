<?php

namespace Tests\Feature;

use App\Http\Resources\Room\RoomResource;
use App\Models\PartialCost;
use App\Models\PartialRates;
use App\Models\PartialTemplate;
use App\Models\Room;
use App\Models\RoomStatus;
use App\Models\RoomType;
use App\Models\ThemeType;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoomTest extends TestCase
{
    use
        DatabaseTransactions,
        WithFaker;

    /**
     * @test
     */
    public function create_successfull()
    {
        $this->withExceptionHandling();
        $user = User::firstWhere('email', 'testing@c.c');
        $partial_cost = PartialCost::all()->random()->first();
        $roomStatus = RoomStatus::all()->random()->first();
        $response = $this
            ->actingAs($user)
            ->postJson(route('room.create'), [
                'room_status_id'     => $room_status_id = $roomStatus->id,
                'partial_cost_id'    => $partial_cost_id = $partial_cost->id,
                'description'        => $description = $this->faker->text(),
                'name' => $name = $this->faker->word()
            ]);

        $response
            ->assertCreated();
        $room = Room::orderBy('id', 'desc')->first();

        $this->assertModelExists($room);
        $this->assertEquals($room_status_id, $room->room_status_id);
        $this->assertEquals($partial_cost_id, $room->partial_cost_id);
        $this->assertEquals($description, $room->description);
        $this->assertEquals($name, $room->name);
    }

    /**
     * @test
     */
    public function create_failed()
    {
        $this->withExceptionHandling();
        $user = User::firstWhere('email', 'testing@c.c');
        $response = $this
            ->actingAs($user)
            ->postJson(route('room.create'), []);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'data' => [
                    'code',
                    'title',
                    'errors'
                ]
            ]);
    }

    /**
     * @test
     */
    public function update_successfull()
    {
        $this->withExceptionHandling();
        $user = User::firstWhere('email', 'testing@c.c');

        $partial_cost = PartialCost::factory()->create();
        $roomStatus = RoomStatus::factory()->create();

        $room = Room::factory()->create();
        $response = $this
            ->actingAs($user)
            ->putJson(route('room.updated', ['room' => $room->id]), [
                'room_status_id'      => $new_status = $roomStatus->id,
                'partial_cost_id'     => $new_partial = $partial_cost->id,
                'description'         => $new_description = $this->faker->text(),
                'name' => $new_rate = $this->faker->word()

            ]);
        $response
            ->assertOk();

        $room->refresh();
        $this->assertEquals($new_status, $room->room_status_id);
        $this->assertEquals($new_partial, $room->partial_cost_id);
        $this->assertEquals($new_description, $room->description);
        $this->assertEquals($new_rate, $room->name);
    }

    /**
     * @test
     */
    public function update_failed_date_template()
    {
        $this->withExceptionHandling();
        $user = User::firstWhere('email', 'testing@c.c');

        $room = Room::factory()->create();

        $response = $this
            ->actingAs($user)
            ->putJson(route('room.updated', ['room' => $room->id]), []);
        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'data' => [
                    'code',
                    'title',
                    'errors'
                ]
            ]);
    }

    /**
     * @test
     */
    public function delete_successfull()
    {
        $this->withExceptionHandling();
        $user = User::firstWhere('email', 'testing@c.c');
        $room = Room::factory()->create();

        $response = $this
            ->actingAs($user)
            ->deleteJson(route('room.delete', ['room' => $room->id]));
        $response
            ->assertOk();

        $room->refresh();

        $this->assertSoftDeleted($room);
    }

    /**
     * @test
     */
    public function delete_failed_date_template()
    {
        $this->withExceptionHandling();
        $user = User::firstWhere('email', 'testing@c.c');
        $response = $this
            ->actingAs($user)
            ->deleteJson(route('room.delete', ['room' => 0]));
        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'data' => [
                    'code',
                    'title',
                    'errors'
                ]
            ]);
    }

    /**
     * @test
     */
    public function get_successfull()
    {
        $this->withExceptionHandling();
        $user = User::firstWhere('email', 'testing@c.c');

        $room = Room::factory(2)->create();


        $response = $this
            ->actingAs($user)
            ->getJson(route('room.get'));

        $room = Room::with([
            'roomStatus',
            'partialCost.roomType',
        ])->withTrashed()->get();

        $response
            ->assertOk()
            ->assertSimilarJson([
                'data' => RoomResource::collection($room)
            ]);
    }


    /**
     * @test
     */
    public function change_status_to_room()
    {
        $room = Room::factory()->create([
            'room_status_id' => 1
        ]);
        $user = User::firstWhere('email', 'testing@c.c');

        $response = $this
            ->actingAs($user)
            ->postJson(route('room.change.status', ['room' => $room->id]), [
                'room_status_id' => 3
            ]);

        $response->assertOk();
        $room->refresh();
        $this->assertEquals(3, $room->room_status_id);
    }

    /**
     * @test
     */
    public function room_with_day_templates()
    {
        $room = Room::orderBy('created_at', 'desc')->first();
        $day_template = \App\Models\DayTemplate::create([
            'room_type_id'    => $room->partialCost->room_type_id,
            'partial_rate_id' => 1, // partial of 6h
            'day_week_id'     => 1, //Monday
            'rate'            => 0,
        ]);

        $partial_cost_current = $room->partial_cost_id;
        (new \App\Services\RoomService\RoomService($room))->getRateByConditionals();
        $partial_cost_new = $room->partial_cost_id;

        $this->assertNotEquals($partial_cost_current, $partial_cost_new);
    }

    /**
     * @test
     */
    public function multiselect_for_update_partial_cost(){
        $user = User::firstWhere('email', 'testing@c.c');
        $room_types = RoomType::all()->random(5)->transform(fn($item) => $item->id);
        $partial_rates = PartialRates::all()->random(5)->transform(fn($item) => $item->id);
        $response = $this
            ->actingAs($user)
            ->postJson(route('partial.cost.multiupdate'), [
                'room_types' => $room_types,
                'partial_rates' => $partial_rates,
                'rate'  => $rate = 1
            ]);

        foreach($room_types as $room_type){
            foreach($partial_rates as $partial_rate){

                $partial_cost = PartialCost::where([
                    ['room_type_id',$room_type],
                    ['partial_rates_id',$partial_rate]
                ])->first();
                $this->assertEquals($rate,$partial_cost->rate);
            }
        }
    }
}
