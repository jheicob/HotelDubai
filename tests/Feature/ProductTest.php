<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
class ProductTest extends TestCase
{

    public function test_create_successfully(){
        $this->withoutExceptionHandling();
        $user = User::find(1);
        $response = $this->actingAs($user)
            ->postJson(route('Product.create'),[

        ]);

        $response->assertCreated()
            ->assertExactJson([]);
    }
}
