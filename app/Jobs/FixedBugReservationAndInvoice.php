<?php

namespace App\Jobs;

use App\Models\Invoice;
use App\Models\Reception;
use App\Services\Invoice\InvoiceService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FixedBugReservationAndInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(InvoiceService $service)
    {
        // $now = Carbon::now()->subMinutes(5)->format('Y-m-d H:i:s');
        $receptions = Reception::whereNull('invoice_id')
                                ->get();

        $receptions->map(function(Reception $reception) use($service) {
            $data = [
                'total' => $service->calculateTotalByReceptionDetails($reception),
                'date'  => Carbon::now()->format('Y-m-d H:i:s'),
                'client_id' => $reception->client_id,
            ];

            $invoice = Invoice::create($data);
            $invoice->identify = config('invoice.local') . '-' . $invoice->id;
            $invoice->save();
            self::storeReceptionDetailsInInvoice($reception,$invoice);
            $reception->invoice_id = $invoice->id;
            $reception->save();
        });
    }

    private function storeReceptionDetailsInInvoice(Reception $reception, Invoice $invoice)
    {
        $reception->details->map(function ($item) use ($invoice,$reception) {

            if(count($item->invoiceDetail) == 0){
                $data = [
                    'price'      => $item->rate,
                    'quantity'   => $item->quantity_partial,
                    'invoice_id' => $invoice->id,
                    'description' => 'hab. '.$reception->room->name.' '.$item->partial_min,
                ];

                $item->invoiceDetail()->create($data);
            }

        if ($item->time_additional) {
            $quantity_aditional = (string) $item->time_additional;
            $quantity_aditional = (int) rtrim($quantity_aditional, 'h');
            $data2 = [
                'price' => $item->price_additional,
                'quantity' => $quantity_aditional,
                'invoice_id' => $invoice->id,
                'description' => 'Adicional hab. '.$reception->room->name.' '.$item->partial_min
            ];
            $item->invoiceDetail()->create($data2);
        }
        });
    }
}
