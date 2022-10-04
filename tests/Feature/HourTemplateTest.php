<?php

namespace Tests\Feature;

use App\Http\Resources\Tarifas\HourTemplate\HourTemplateResource;
use App\Models\HourTemplate;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HourTemplateTest extends TestCase
{
    Use
        DatabaseTransactions,
        WithFaker
        ;

    /**
     * @test
     */
    public function create_successfull_with_negative_rate(){
        $this->withExceptionHandling();
        $user = User::firstWhere('email','testing@c.c');
        $roomType = RoomType::all()->random()->first();

        $response = $this
                        ->actingAs($user)
                        ->postJson(route('hour.templates.create'),[
                            'room_type_id' => $roomType->id,
                            'hour'         => '08:30',
                            'rate'         => '-30',
                        ]);

        $response
            ->assertCreated();

        $dateTemplate = HourTemplate::first();

        $this->assertModelExists($dateTemplate);
    }

    /**
     * @test
     */
    public function create_failed_date_template(){
        $this->withExceptionHandling();
        $user = User::firstWhere('email','testing@c.c');
        $roomType = RoomType::all()->random()->first();

        $response = $this
                        ->actingAs($user)
                        ->postJson(route('hour.templates.create'),[]);

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

        $roomType = RoomType::all()->random(2);
        $dateTemplate = HourTemplate::create([
            'room_type_id' => $roomType[0]->id,
            'hour'         => '08:30',
            'rate'         => '-30'
        ]);

        $response = $this
                        ->actingAs($user)
                        ->putJson(route('hour.templates.updated',['id'=> $dateTemplate->id]),[
                            'room_type_id' => $roomType[1]->id,
                            'hour'         => $new_date = '09:30',
                            'rate'         => '30',
                        ]);
        $response
            ->assertOk();

        $dateTemplate->refresh();

        $this->assertEquals($roomType[1]->id,$dateTemplate->room_type_id);
        $this->assertEquals($new_date,$dateTemplate->hour);
        $this->assertEquals(30,$dateTemplate->rate);
    }

    /**
     * @test
     */
    public function update_failed_date_template(){
        $this->withExceptionHandling();
        $user = User::firstWhere('email','testing@c.c');
        $roomType = RoomType::all()->random(2);
        $dateTemplate = HourTemplate::create([
            'room_type_id' => $roomType[0]->id,
            'hour'         => '08:30',
            'rate'         => '-30'
        ]);
        $response = $this
                        ->actingAs($user)
                        ->putJson(route('hour.templates.updated',['id'=> $dateTemplate->id]),[]);
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
    public function delete_successfull_date_template(){
        $this->withExceptionHandling();
        $user = User::firstWhere('email','testing@c.c');

        $roomType = RoomType::all()->random(2);
        $dateTemplate = HourTemplate::create([
            'room_type_id' => $roomType[0]->id,
            'hour'         => '08:30',
            'rate'         => '-30'
        ]);
        $response = $this
                        ->actingAs($user)
                        ->deleteJson(route('hour.templates.delete',['id'=> $dateTemplate->id]));
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
        $roomType = RoomType::all()->random(2);
        $dateTemplate = HourTemplate::create([
            'room_type_id' => $roomType[0]->id,
            'hour'         => '08:30',
            'rate'         => '-30'
        ]);
        $response = $this
                        ->actingAs($user)
                        ->deleteJson(route('hour.templates.delete',['id'=>40]));
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
    public function get_successfull_date_template(){
        $this->withExceptionHandling();
        $user = User::firstWhere('email','testing@c.c');

        $roomType = RoomType::all()->random(2);
        HourTemplate::create([
            'room_type_id' => $roomType[0]->id,
            'hour'         => '10:30',
            'rate'         => '-30'
        ]);

        HourTemplate::create([
            'room_type_id' => $roomType[1]->id,
            'hour'         => '08:30',
            'rate'         => '30'
        ]);

        $response = $this
                        ->actingAs($user)
                        ->getJson(route('hour.templates.get'));

        $dateTemplate = HourTemplate::with(['roomType'])->withTrashed()->get();

        $response
            ->assertOk()
            ->assertSimilarJson([
                'data' => HourTemplateResource::collection($dateTemplate)
                ])
            ;
    }

}
