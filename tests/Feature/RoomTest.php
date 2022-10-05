<?php

namespace Tests\Feature;

use App\Http\Resources\Room\RoomResource;
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
    Use
        DatabaseTransactions,
        WithFaker
    ;

/**
 * @test
 */
public function create_successfull(){
    $this->withExceptionHandling();
    $user = User::firstWhere('email','testing@c.c');
    $partialTemplate = PartialTemplate::all()->random()->first();
    $themeType = ThemeType::all()->random()->first();
    $roomStatus = RoomStatus::all()->random()->first();
    $response = $this
                    ->actingAs($user)
                    ->postJson(route('room.create'),[
                        'room_status_id'     => $roomStatus->id,
                        'partial_template_id'=> $partialTemplate->id,
                        'theme_type_id'      => $themeType->id,
                        'description'        => $this->faker->text(),
                    ]);

    $response
        ->assertCreated();

    $room = Room::first();

    $this->assertModelExists($room);
}

/**
 * @test
 */
public function create_failed(){
    $this->withExceptionHandling();
    $user = User::firstWhere('email','testing@c.c');
    $response = $this
                    ->actingAs($user)
                    ->postJson(route('room.create'),[]);

    $response
        ->assertStatus(422)
        ->assertJsonStructure([
            'data' => [
                'code',
                'title',
                'errors'
            ]
        ])
        ;
}

/**
 * @test
 */
public function update_successfull(){
    $this->withExceptionHandling();
    $user = User::firstWhere('email','testing@c.c');

    $partialTemplate = PartialTemplate::all()->random(2);
    $themeType = ThemeType::all()->random(2);
    $roomStatus = RoomStatus::all()->random(2);

    $room = Room::create([
        'room_status_id'     => $roomStatus[0]->id,
        'partial_template_id'=> $partialTemplate[0]->id,
        'theme_type_id'      => $themeType[0]->id,
        'description'        => $this->faker->text(),
    ]);
    $response = $this
                    ->actingAs($user)
                    ->putJson(route('room.updated',['room'=> $room->id]),[
                        'room_status_id'      => $new_status = $roomStatus[1]->id,
                        'partial_template_id' => $new_partial = $partialTemplate[1]->id,
                        'theme_type_id'       => $new_theme = $themeType[1]->id,
                        'description'         => $new_description = $this->faker->text(),
                    ]);
    $response
        ->assertOk();

    $room->refresh();

    $this->assertEquals($new_status, $room->room_status_id);
    $this->assertEquals($new_partial, $room->partial_template_id);
    $this->assertEquals($new_theme, $room->theme_type_id);
    $this->assertEquals($new_description, $room->description);
}

/**
 * @test
 */
public function update_failed_date_template(){
    $this->withExceptionHandling();
    $user = User::firstWhere('email','testing@c.c');
    $partialTemplate = PartialTemplate::all()->random(2);
    $themeType = ThemeType::all()->random(2);
    $roomStatus = RoomStatus::all()->random(2);
    $room = Room::create([
        'room_status_id'     => $roomStatus[0]->id,
        'partial_template_id'=> $partialTemplate[0]->id,
        'theme_type_id'      => $themeType[0]->id,
        'description'        => $this->faker->text(),
    ]);

    $response = $this
                    ->actingAs($user)
                    ->putJson(route('room.updated',['room'=> $room->id]),[]);
    $response
        ->assertStatus(422)
        ->assertJsonStructure([
            'data' => [
                'code',
                'title',
                'errors'
            ]
        ])
        ;
}

/**
 * @test
 */
public function delete_successfull(){
    $this->withExceptionHandling();
    $user = User::firstWhere('email','testing@c.c');
    $partialTemplate = PartialTemplate::all()->random(2);
    $themeType = ThemeType::all()->random(2);
    $roomStatus = RoomStatus::all()->random(2);
    $room = Room::create([
        'room_status_id'     => $roomStatus[0]->id,
        'partial_template_id'=> $partialTemplate[0]->id,
        'theme_type_id'      => $themeType[0]->id,
        'description'        => $this->faker->text(),
    ]);
    $response = $this
                    ->actingAs($user)
                    ->deleteJson(route('room.delete',['room'=> $room->id]));
    $response
        ->assertOk();

    $room->refresh();

    $this->assertSoftDeleted($room);
}

/**
 * @test
 */
public function delete_failed_date_template(){
    $this->withExceptionHandling();
    $user = User::firstWhere('email','testing@c.c');
    $response = $this
                    ->actingAs($user)
                    ->deleteJson(route('room.delete',['room'=>0]));
    $response
        ->assertStatus(422)
        ->assertJsonStructure([
            'data' => [
                'code',
                'title',
                'errors'
            ]
        ])
        ;
}

/**
 * @test
 */
public function get_successfull(){
    $this->withExceptionHandling();
    $user = User::firstWhere('email','testing@c.c');

    $partialTemplate = PartialTemplate::all()->random(2);
    $themeType = ThemeType::all()->random(2);
    $roomStatus = RoomStatus::all()->random(2);
    Room::create([
        'room_status_id'     => $roomStatus[0]->id,
        'partial_template_id'=> $partialTemplate[0]->id,
        'theme_type_id'      => $themeType[0]->id,
        'description'        => $this->faker->text(),
    ]);
    Room::create([
        'room_status_id'     => $roomStatus[1]->id,
        'partial_template_id'=> $partialTemplate[1]->id,
        'theme_type_id'      => $themeType[1]->id,
        'description'        => $this->faker->text(),
    ]);

    $response = $this
                    ->actingAs($user)
                    ->getJson(route('room.get'));

    $room = Room::with([
        'roomStatus',
        'partialTemplate',
        'themeType'
        ])->withTrashed()->get();

    $response
        ->assertOk()
        ->assertSimilarJson([
            'data' => RoomResource::collection($room)
            ])
        ;
}
}
