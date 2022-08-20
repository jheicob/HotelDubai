<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function test_user_can_rendered()
    {
        $this->withoutExceptionHandling();

        $admin = Auth::loginUsingId(1);

        $this->actingAs($admin)->get('/users')
            ->assertStatus(200);
    }

    /**
     * @test
     */
    public function test_user_can_store()
    {
        $this->withoutExceptionHandling();

        $admin = Auth::loginUsingId(1);

        $this->actingAs($admin)
            ->post('/users/create', [
                "name"     => "prueba user",
                'email'    => "user@user.com",
                'password' => "password",
            ])
            ->assertStatus(200);


        $this->assertDatabaseHas('users', ["email" => "user@user.com"]);
    }

    /**
     * @test
     */
    public function test_user_role_can_store()
    {
        $this->withoutExceptionHandling();

        $admin = Auth::loginUsingId(1);

        $this->actingAs($admin)
            ->post('/users/create', [
                "name"     => "prueba user",
                'email'    => "user@user.com",
                'password' => "password",
                'role_id'  => [1],

            ])
            ->assertStatus(200);


        $this->assertDatabaseHas('users', ["email" => "user@user.com"]);
    }

    /**
     * @test
     */
    public function test_user_email_unique_can_store()
    {
        $admin = Auth::loginUsingId(1);

        $this->actingAs($admin)
            ->post('/users/create', [
                "name"     => "prueba user",
                'email'    => "testing@c.c",
                'password' => "password",
                'role_id'  => [1],

            ])
            ->assertSessionHasErrors('email');
    }

    /**
     * @test
     */
    public function test_user_required_can_store()
    {
        $admin = Auth::loginUsingId(1);

        $this->actingAs($admin)
            ->post('/users/create', [
                "name"     => "",
                'email'    => "",
                'password' => "password",
                'role_id'  => [1],

            ])
            ->assertSessionHasErrors('email', 'name');
        //dd(session('errors'));
    }

    /**
     * @test
     */
    public function test_user_can_list()
    {
        $this->withoutExceptionHandling();

        $admin = Auth::loginUsingId(1);

        $this->actingAs($admin)->get('/users/get')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'attributes' => [
                            'name',
                            'email',
                            'deleted_at',
                        ]
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function test_user_can_delete()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $admin = Auth::loginUsingId(1);

        $this->actingAs($admin)
            ->delete("/users/delete/$user->id")
            ->assertStatus(200);
    }

    /**
     * @test
     */
    public function test_user_can_update()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $admin = Auth::loginUsingId(1);

        $this->actingAs($admin)
            ->put("/users/$user->id",[
                "name"     => "prueba user",
                'email'    => "user@user.com",
                'password' => "password",
            ])
            ->assertStatus(200);
    }
}
