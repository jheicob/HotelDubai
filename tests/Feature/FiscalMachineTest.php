<?php

namespace Tests\Feature;

use App\Models\FiscalMachine;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FiscalMachineTest extends TestCase
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
        $user = \App\Models\User::firstWhere('email','testing@c.c');

        $response = $this
                        ->actingAs($user)
                        ->postJson(route('FiscalMachines.create'),[
                            'name'   => $name =  'caja '. rand(1,10),
                            'serial' => $serial =  $this->faker->regexify('/[aA-Zz\w\d]{1,10}/'),
                            'rate'   => $rate =  '-30',
                        ]);

        $response
            ->assertCreated();

        $fiscalMachine = FiscalMachine::first();

        $this->assertModelExists($fiscalMachine);
        $this->assertEquals($name, $fiscalMachine->name);
        $this->assertEquals($serial, $fiscalMachine->serial);
        $this->assertEquals($rate, $fiscalMachine->rate);
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
}
