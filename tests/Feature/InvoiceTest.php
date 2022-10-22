<?php

namespace Tests\Feature;

use App\Models\Invoice;
use App\Models\Reception;
use App\Models\ReceptionDetail;
use App\Models\User;
use App\Services\FiscalInvoice\CreditNoteService;
use App\Services\FiscalInvoice\DebitNoteService;
use App\Services\Invoice\InvoiceService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvoiceTest extends TestCase
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
            ->postJson(route('invoice.create'), []);

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
    public function create_successfully(){
        // $this->withoutExceptionHandling();
        $user = User::firstWhere('email', 'testing@c.c');

        $reception = Reception::find(2);

        $response = $this
            ->actingAs($user)
            ->postJson(route('invoice.create'), [
                'client_id'     => $reception->client_id,
                'observation'   => $obs = $this->faker->text(),
                'reception_details' => [
                    [
                        'id' => '2',
                        'time_additional' => '',
                        'price_additional'=> 0
                    ]
                ]
            ]);

        $response
        ->assertCreated()
        // ->assertExactJson([])
            ;

        $reception->refresh();

        $invoice = Invoice::orderBy('created_at','desc')->first();

        $invoice_service = new InvoiceService(new Invoice,new CreditNoteService, new DebitNoteService);

        $this->assertDatabaseHas('invoices',$invoice->toArray());
        $this->assertEquals($reception->client_id,$invoice->client_id,);
        $this->assertEquals($obs,$invoice->observation);
        $this->assertEquals($invoice_service->calculateTotalByReceptionDetails($reception),$invoice->total);

        // verified invoice details
        $invoice_details = $invoice->details;     // la recepción tiene 2 elementos
        $reception_details = $reception->details; // la recepción tiene 2 elementos

        $this->assertEquals($invoice_details[0]->productable_id,   $reception_details[0]->id);
        $this->assertEquals($invoice_details[0]->productable_type, ReceptionDetail::class);
        $this->assertEquals($invoice_details[0]->quantity, $reception_details[0]->quantity_partial);
        $this->assertEquals($invoice_details[0]->price, $reception_details[0]->rate);
        // get description from reception_detail

        $this->assertEquals(1,$reception->invoiced);
    }

}
