<?php

namespace Tests\Feature;

use App\Http\Resources\Tarifas\DayTemplate\DayTemplateResource;
use App\Models\DateTemplate;
use App\Models\DayTemplate;
use App\Models\DayWeek;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DayTemplateTest extends TestCase
{
    Use
    DatabaseTransactions,
    WithFaker
    ;

/**
 * @test
 */
public function create_successfull_with_negative_rate(){
    $this->withoutExceptionHandling();
    $user = User::firstWhere('email','testing@c.c');
    $roomType = RoomType::factory()->create();
    $dayWeek  = DayWeek::factory()->create();

    $response = $this
                    ->actingAs($user)
                    ->postJson(route('day.templates.create'),[
                        'room_type_id' => $room_type_id = $roomType->id,
                        'day_week_id'  => $day_week_id = $dayWeek->id,
                        'rate'         => $rate = $this->faker->numberBetween(-100,100),
                    ]);

    $response
        ->assertCreated();

    $dayTemplate = DayTemplate::first();

    $this->assertModelExists($dayTemplate);
    $this->assertEquals($room_type_id,$dayTemplate->room_type_id);
    $this->assertEquals($day_week_id,$dayTemplate->day_week_id);
    $this->assertEquals($rate,$dayTemplate->rate);
}

/**
 * @test
 */
public function create_failed_date_template(){
    $this->withExceptionHandling();
    $user = User::firstWhere('email','testing@c.c');

    $response = $this
                    ->actingAs($user)
                    ->postJson(route('day.templates.create'),[]);

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
public function update_successfull_date_template(){
    $this->withExceptionHandling();
    $user = User::firstWhere('email','testing@c.c');

    $roomType = RoomType::factory()->create();
    $dateTemplate = DayTemplate::factory()->create();
    $dayWeek  = DayWeek::factory()->create();

    $response = $this
                    ->actingAs($user)
                    ->putJson(route('day.templates.updated',['daytemplate'=> $dateTemplate->id]),[
                        'room_type_id' => $roomType->id,
                        'day_week_id'  => $day_week_id = $dayWeek->id,
                        'rate'         => '30',
                    ]);
    $response
        ->assertOk();

    $dateTemplate->refresh();

    $this->assertEquals($roomType->id,$dateTemplate->room_type_id);
    $this->assertEquals($day_week_id,$dateTemplate->day_week_id);
    $this->assertEquals(30,$dateTemplate->rate);
}

/**
 * @test
 */
public function update_failed_date_template(){
    $this->withExceptionHandling();
    $user = User::firstWhere('email','testing@c.c');
    $dateTemplate = DayTemplate::factory()->create();


    $response = $this
                    ->actingAs($user)
                    ->putJson(route('day.templates.updated',['daytemplate'=> $dateTemplate->id]),[]);
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
    $dateTemplate = DayTemplate::factory()->create();

    $response = $this
                    ->actingAs($user)
                    ->deleteJson(route('day.templates.delete',['daytemplate'=> $dateTemplate->id]));
    $response
        ->assertOk();

    $dateTemplate->refresh();

    $this->assertSoftDeleted($dateTemplate);
}

/**
 * @test
 */
public function delete_failed_date_template(){
    $this->withExceptionHandling();
    $user = User::firstWhere('email','testing@c.c');

    $response = $this
                    ->actingAs($user)
                    ->deleteJson(route('day.templates.delete',['daytemplate'=>0]));
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

    DayTemplate::factory(2)->create();


    $response = $this
                    ->actingAs($user)
                    ->getJson(route('day.templates.get'));

    $dateTemplate = DayTemplate::with([
                    'roomType',
                    'dayWeek'
                ])->withTrashed()->get();

    $response
        ->assertOk()
        ->assertSimilarJson([
            'date' => DayTemplateResource::collection($dateTemplate)
            ])
        ;
}
}
