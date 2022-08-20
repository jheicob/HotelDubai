<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function test_permission_can_rendered()
    {
        $this->withoutExceptionHandling();

        $admin = Auth::loginUsingId(1);

        $this->actingAs($admin)->get('/permissions')
            ->assertStatus(200);
    }

    /**
     * @test
     */
    public function test_permission_can_store()
    {
        $this->withoutExceptionHandling();

        $admin = Auth::loginUsingId(1);

        $this->actingAs($admin)
            ->post('permissions/create', ["name" => "prueba permiso"])
            ->assertStatus(200);


        $this->assertDatabaseHas('permissions', ["name" => "prueba permiso"]);
    }

    /**
     * @test
     */
    public function test_permission_can_list()
    {
        $this->withoutExceptionHandling();

        $admin = Auth::loginUsingId(1);

        $response =  $this->actingAs($admin)->get('/permissions/get')
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
    public function test_permission_can_update()
    {
        $this->withoutExceptionHandling();

        $admin = Auth::loginUsingId(1);

        $this->actingAs($admin)
            ->put('/permissions/1', ["name" => "prueba permiso"])
            ->assertStatus(200);


        $this->assertDatabaseHas('permissions', ["name" => "prueba permiso"]);
    }

    /**
     * @test
     */
    public function test_permission_can_delete()
    {
        $this->withoutExceptionHandling();

        $admin = Auth::loginUsingId(1);

        $this->actingAs($admin)
            ->delete('/permissions/delete/1')
            ->assertStatus(200);


        $this->assertDatabaseMissing('permissions', ["name" => "seguridad"]);
    }
}
