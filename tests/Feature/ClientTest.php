<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Client;
use App\Http\Resources\Client\ClientResource;
use Illuminate\Http\Request;

class ClientTest extends TestCase
{
    use
        DatabaseTransactions,
        WithFaker;

    /**
     * @test
     */
    public function create_failed()
    {
        $this->withExceptionHandling();
        $user = User::firstWhere('email', 'testing@c.c');
        $response = $this
            ->actingAs($user)
            ->postJson(route('client.create'), []);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'data' => [
                    'code',
                    'title',
                    'errors'
                ]
            ]);
    }

    /**
     * @test
     */
    public function create_successfully()
    {
        $this->withExceptionHandling();
        $user = User::firstWhere('email', 'testing@c.c');
        $response = $this
            ->actingAs($user)
            ->postJson(route('client.create'), [
                'document' => $document = $this->faker->unique()->word(),
                'first_name' => $first_name = $this->faker->firstName(),
                'last_name' => $last_name = $this->faker->lastName(),
                'phone' => $phone = '0424-7621859',
                'email' => $email = $this->faker->email(),
            ]);

        $response
            ->assertCreated();
        $client = Client::firstWhere('document', $document);
        $this->assertEquals($document, $client->document);
        $this->assertEquals($first_name, $client->first_name);
        $this->assertEquals($last_name, $client->last_name);
        $this->assertEquals($phone, $client->phone);
        $this->assertEquals($email, $client->email);
    }

     /**
     * @test
     */
    public function upsert_successfully()
    {
        $this->withExceptionHandling();
        $user = User::firstWhere('email', 'testing@c.c');
        $client = Client::factory()->create([
            'document' => $document = 1
        ]);
        $response = $this
            ->actingAs($user)
            ->postJson(route('client.create'), [
                'document' => $document,
                'first_name' => $first_name = $this->faker->firstName(),
                'last_name' => $last_name = $this->faker->lastName(),
                'phone' => $phone = '0424-7621859',
                'email' => $email = $this->faker->email(),
            ]);

        $response
            ->assertCreated();
        $this->assertCount(1,Client::all());
        $client->refresh();
        $this->assertEquals($document, $client->document);
        $this->assertEquals($first_name, $client->first_name);
        $this->assertEquals($last_name, $client->last_name);
        $this->assertEquals($phone, $client->phone);
        $this->assertEquals($email, $client->email);
    }

    /**
     * @test
     */
    public function update_failed()
    {
        $this->withExceptionHandling();
        $user = User::firstWhere('email', 'testing@c.c');
        $client = Client::factory()->create();
        $response = $this
            ->actingAs($user)
            ->putJson(route('client.updated', ['client' => $client->id]));

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'data' => [
                    'code',
                    'title',
                    'errors'
                ]
            ]);
    }

    /**
     * @test
     */
    public function update_successfully()
    {
        $this->withExceptionHandling();
        $user = User::firstWhere('email', 'testing@c.c');
        $client = Client::factory()->create();

        $response = $this
            ->actingAs($user)
            ->putJson(route('client.updated', ['client' => $client->id]), [
                'document' => $document = $this->faker->unique()->word(),
                'first_name' => $first_name = $this->faker->firstName(),
                'last_name' => $last_name = $this->faker->lastName(),
                'phone' => $phone = '0424-7621859',
                'email' => $email = $this->faker->email(),
            ]);


        $response
            ->assertOk()
            // ->assertExactJson([
            //     'message' => 'updated'
            // ])
        ;
        $client = Client::firstWhere('document', $document);
        $this->assertEquals($document, $client->document);
        $this->assertEquals($first_name, $client->first_name);
        $this->assertEquals($last_name, $client->last_name);
        $this->assertEquals($phone, $client->phone);
        $this->assertEquals($email, $client->email);
    }

    /**
     * @test
     */
    public function delete_failed()
    {
        $this->withExceptionHandling();
        $user = User::firstWhere('email', 'testing@c.c');
        $client = Client::factory()->create();
        $response = $this
            ->actingAs($user)
            ->deleteJson(route('client.delete', ['client' => 0]));

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'data' => [
                    'code',
                    'title',
                    'errors'
                ]
            ]);
    }

    /**
     * @test
     */
    public function delete_successfully()
    {
        $this->withExceptionHandling();
        $user = User::firstWhere('email', 'testing@c.c');
        $client = Client::factory()->create();

        $response = $this
            ->actingAs($user)
            ->deleteJson(route('client.delete', ['client' => $client->id]));


        $response
            ->assertOk()
            // ->assertExactJson([
            //     'message' => 'updated'
            // ])
        ;
        $client->refresh();
        $this->assertSoftDeleted($client);
    }

    /**
     * @test
     */
    public function get_successfully()
    {
        $this->withExceptionHandling();
        $user = User::firstWhere('email', 'testing@c.c');

        $client = Client::factory(2)->create();


        $response = $this
            ->actingAs($user)
            ->getJson(route('client.get'));

        $response
            ->assertOk()
            ->assertSimilarJson([
                'data' => ClientResource::collection($client)
            ]);
    }

    /**
     * @test
     */
    public function get_filter_successfully()
    {
        $this->withExceptionHandling();
        $user = User::firstWhere('email', 'testing@c.c');

        Client::factory()->create([
            'document' => '12345'
        ]);
        Client::factory()->create([
            'document' => '56789'
        ]);

        $client_with_1 = Client::filter(new Request([
            'document' => 1
        ]))->get();
        $clients_with_5 = Client::filter(new Request([
            'document' => 5
        ]))->get();

        $this->assertCount(1,$client_with_1);
        $this->assertCount(2,$clients_with_5);
    }
}
