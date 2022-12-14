<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Client;
use App\Http\Resources\Client\ClientResource;
use App\Models\ClientRoom;
use App\Models\Reception;
use App\Models\Room;
use App\Models\RoomStatus;
use App\Models\TypeDocument;
use App\Services\RoomService\RoomService;
use Carbon\Carbon;
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
        $typeDocument = TypeDocument::factory()->create();
        $response = $this
            ->actingAs($user)
            ->postJson(route('client.create'), [
                'document' => $document = $this->faker->unique()->word(),
                'type_document_id' => $type_document_id= $typeDocument->id,
                'first_name' => $first_name = $this->faker->firstName(),
                'last_name' => $last_name = $this->faker->lastName(),
                'phone' => $phone = '0424-7621859',
                'email' => $email = $this->faker->email(),
            ]);

        $response
            ->assertCreated();
        $client = Client::firstWhere('document', $document);
        $this->assertEquals($document, $client->document);
        $this->assertEquals($type_document_id,$client->type_document_id);
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
        $typeDocument = TypeDocument::factory()->create();
        $client = Client::factory()->create([
            'document' => $document = 1,
            'type_document_id' => $typeDocument->id
        ]);

        $response = $this
            ->actingAs($user)
            ->postJson(route('client.create'), [
                'document' => $document,
                'type_document_id' => $type_document_id = $typeDocument->id,
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

    /**
     * @test
     */
    public function assign_room_to_client_successfully(){
        $this->withExceptionHandling();
        $user = User::firstWhere('email', 'testing@c.c');
        $client = Client::factory()->create();
        $roomStatus = RoomStatus::firstWhere('name','Disponible');
        $room = Room::factory()
                ->create(['room_status_id'=> $roomStatus->id]);
        $roomStatus_ocuppy = RoomStatus::firstWhere('name','Ocupada');
        $response = $this
                        ->actingAs($user)
                        ->postJson(route('client.assigned_room'),[
                            'client_id'        => $client_id = $client->id,
                            'room_id'          => $room_id = $room->id,
                            'date_in'          => $date_in = Carbon::now()->format('Y-m-d H:i'),
                            'observation'      => $observation = $this->faker->optional()->text(),
                            'quantity_partial' => $quantity_partial = $this->faker->randomDigit(),

                        ]);

        $response
            ->assertOk();

        $client_room = Reception::first();

        $partial_cost = $room->partialCost;
        $partial_cost->partialRate->append('number_hour');

        $hour_partial = $room->partialCost->partialRate->number_hour;

        $this->assertEquals($client_id, $client_room->client_id);
        $this->assertEquals($room_id, $client_room->room_id);
        $this->assertEquals($date_in, $client_room->date_in);
        $this->assertEquals(Carbon::parse($date_in)->addHours($hour_partial)->format('Y-m-d H:i'),$client_room->date_out);

        $reception_detail = $client_room->details->first();
        $this->assertEquals($observation, $reception_detail->observation);
        $this->assertEquals($quantity_partial, $reception_detail->quantity_partial);
        $this->assertEquals($partial_cost->partialRate->name,$reception_detail->partial_min);
        $this->assertEquals($partial_cost->rate,$reception_detail->rate);

        $room->refresh();
        $this->assertEquals($roomStatus_ocuppy->id,$room->room_status_id);
    }

    /**
     * @test
     */
    public function renew_room_to_client(){
        $room = Room::find(98);
        $room_service = new RoomService($room);
        $rate = $room_service->getRateByConditionals();
        dd($rate);
    }
}
