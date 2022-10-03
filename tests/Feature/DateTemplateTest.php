<?php

namespace Tests\Feature;

use App\Models\DateTemplate;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DateTemplateTest extends TestCase
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
                        ->postJson(route('date.templates.create'),[
                            'room_type_id' => $roomType->id,
                            'date'         => $this->faker->date('m-d'),
                            'rate'         => '-30',
                        ]);

        $response
            ->assertCreated();

        $dateTemplate = DateTemplate::first();

        $this->assertModelExists($dateTemplate);
    }
}
