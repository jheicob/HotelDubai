<?php

namespace App\Http\Controllers\Invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\CreateRequest;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use App\Models\ReceptionDetail;
use App\Services\Invoice\InvoiceService;

class CreateController extends Controller
{
    protected $service;

    public function __construct(InvoiceService $service)
    {
        $this->service = $service;
    }

    public function create(CreateRequest $request)
    {
        try {
            DB::beginTransaction();

            $client = Client::find($request->client_id);

            $reception = $client->receptionActive->first();

            $request->merge([
                'total' => $this->service->calculateTotalByReceptionDetails($reception)
            ]);
            dump($request->observation);
            $invoice = new Invoice();
            $invoice = Invoice::create($request->only([
                'client_id',
                'total',
                'observation',
                'date'
            ]));
            dump($invoice->observation);
            $reception->details->map(function($item) use ($invoice){
                $data = [
                    'price'      => $item->rate,
                    'quantity'   => $item->quantity_partial,
                    'invoice_id' => $invoice->id
                ];

                $item->invoiceDetail()->create($data);
            });
            // $invoice_details = $invoice->details()->create()
            DB::commit();

            return custom_response_sucessfull('created successfull',201);

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }



}
