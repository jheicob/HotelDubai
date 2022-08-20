<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function test_role_can_rendered()
    {
        $this->withoutExceptionHandling();

        $admin = Auth::loginUsingId(1);

        $this->actingAs($admin)->get('/roles')
            ->assertStatus(200);
    }

    /**
     * @test
     */
    public function test_role_can_store()
    {
        $this->withoutExceptionHandling();

        $admin = Auth::loginUsingId(1);

        $this->actingAs($admin)
            ->post('roles/create', ["name" => "prueba rol"])
            ->assertStatus(200);


        $this->assertDatabaseHas('roles', ["name" => "prueba rol"]);
    }

    /**
     * @test
     */
    public function test_role_can_list()
    {
        $this->withoutExceptionHandling();

        $admin = Auth::loginUsingId(1);

        $response =  $this->actingAs($admin)->get('/roles/get')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'attributes' => [
                            'name',
                            'guard_name',
                            'updated_at',
                            'created_at',
                        ]
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function test_role_can_update()
    {
        $this->withoutExceptionHandling();

        $admin = Auth::loginUsingId(1);

        $this->actingAs($admin)
            ->put('/roles/1', ["name" => "prueba rol"])
            ->assertStatus(200);


        $this->assertDatabaseHas('roles', ["name" => "prueba rol"]);
    }

    /**
     * @test
     */
    public function test_role_can_delete()
    {
        $this->withoutExceptionHandling();

        $admin = Auth::loginUsingId(1);

        $this->actingAs($admin)
            ->delete('/roles/delete/1')
            ->assertStatus(200);


        $this->assertDatabaseMissing('roles', ["name" => "Admin"]);
    }
}
