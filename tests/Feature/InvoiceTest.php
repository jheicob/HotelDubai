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
    public function create_successfully()
    {
        // $this->withoutExceptionHandling();
        $user = User::firstWhere('email', 'testing@c.c');

        $reception = Reception::find(12);

        $response = $this
            ->actingAs($user)
            ->postJson(route('invoice.create'), [
                'client_id'     => $reception->client_id,
                'observation'   => $obs = $this->faker->text(),
                // 'reception_details' => [
                //     [
                //         'id' => '2',
                //         'time_additional' => '',
                //         'price_additional'=> 0
                //     ]
                // ]
                'payments' => [
                    [
                        'type'        => $payment_type = $this->faker->randomElement(['divisa', 'Bs']),
                        'method'      => $payment_method = $this->faker->randomElement(['efectivo', 'digital', 'tarjeta']),
                        'quantity'    => $payment_quantity = 20,
                        'description' => $payment_description = $this->faker->text(),
                    ],
                    [
                        'type'        => $payment2_type = $this->faker->randomElement(['divisa', 'Bs']),
                        'method'      => $payment2_method = $this->faker->randomElement(['efectivo', 'digital', 'tarjeta']),
                        'quantity'    => $payment2_quantity = 20,
                        'description' => $payment2_description = $this->faker->text(),
                    ]
                ]
            ]);

        $response
            ->assertCreated()
            // ->assertExactJson([])
        ;

        $reception->refresh();

        $invoice = Invoice::orderBy('created_at', 'desc')->first();

        $invoice_service = new InvoiceService(new Invoice, new CreditNoteService, new DebitNoteService);

        $this->assertDatabaseHas('invoices', $invoice->toArray());
        $this->assertEquals($reception->client_id, $invoice->client_id,);
        $this->assertEquals($obs, $invoice->observation);
        $this->assertEquals($invoice_service->calculateTotalByReceptionDetails($reception), $invoice->total);

        // verified invoice details
        $invoice_details = $invoice->details;     // la recepción tiene 2 elementos
        $reception_details = $reception->details; // la recepción tiene 2 elementos

        $this->assertEquals($invoice_details[0]->productable_id,   $reception_details[0]->id);
        $this->assertEquals($invoice_details[0]->productable_type, ReceptionDetail::class);
        $this->assertEquals($invoice_details[0]->quantity, $reception_details[0]->quantity_partial);
        $this->assertEquals($invoice_details[0]->price, $reception_details[0]->rate);
        // get description from reception_detail

        $this->assertEquals(1, $reception->invoiced);

        $this->assertCount(2, $invoice->payments);

        $this->assertEquals($payment_type, $invoice->payments[0]->type);
        $this->assertEquals($payment_method, $invoice->payments[0]->method);
        $this->assertEquals($payment_quantity, $invoice->payments[0]->quantity);
        $this->assertEquals($payment_description, $invoice->payments[0]->description);

        $this->assertEquals($payment2_type, $invoice->payments[1]->type);
        $this->assertEquals($payment2_method, $invoice->payments[1]->method);
        $this->assertEquals($payment2_quantity, $invoice->payments[1]->quantity);
        $this->assertEquals($payment2_description, $invoice->payments[1]->description);

        $this->assertEquals($payment_quantity + $payment2_quantity, $invoice->total_payment);
    }
}
