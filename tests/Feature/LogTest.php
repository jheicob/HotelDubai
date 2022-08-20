<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LogTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function test_log_can_rendered()
    {
        $this->withoutExceptionHandling();

        $admin = Auth::loginUsingId(1);

        $this->actingAs($admin)->get('/logs')
            ->assertStatus(200);
    }

    public function test_log_can_list()
    {
        $this->withoutExceptionHandling();

        $admin = Auth::loginUsingId(1);

        $this->actingAs($admin)->get('/logs/get')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'attributes' => [
                            'event',
                            'auditable_type',
                            'auditable_id',
                            'old_values',
                            'new_values',
                        ]
                    ]
                ]
            ]);
    }
}
