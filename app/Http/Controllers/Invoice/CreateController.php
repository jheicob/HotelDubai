<?php

namespace App\Http\Controllers\Invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\CreateRequest;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use App\Models\Reception;
use App\Models\ReceptionDetail;
use App\Services\FiscalInvoice\DebitNoteService;
use App\Services\Invoice\InvoiceService;
use Carbon\Carbon;

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
                'total' => $this->service->calculateTotalByReceptionDetails($reception),
                'date'  => Carbon::now()->format('Y-m-d H:i:s')
            ]);
            //           $invoice = new Invoice();
            //dump($request->only(['client_id','total','observation','date']));
            $invoice = Invoice::create($request->only([
                'client_id',
                'total',
                'observation',
                'date'
            ]));
            $reception->details->map(function ($item) use ($invoice) {
                $data = [
                    'price'      => $item->rate,
                    'quantity'   => $item->quantity_partial,
                    'invoice_id' => $invoice->id
                ];

                $item->invoiceDetail()->create($data);
            });
            // $invoice_details = $invoice->details()->create()
            $reception->update(['invoiced' => true]);
            $roomStatus = \App\Models\RoomStatus::firstWhere('name', 'Disponible');
            $reception->room->update(['room_status_id' => $roomStatus->id]);
            DB::commit();

            return custom_response_sucessfull([
                'status' => 'created successfull',
                'id'     => $invoice->id
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e, __('errors.server.title'), 500);
        }
    }

    public function printFiscal(Invoice $invoice, Request $request)
    {
        $igtf = $request->igtf == 'true' ? true : false;
        // return ';';
        $client = $invoice->client;
        $client->append('full_name');
        $debit_note = new DebitNoteService();
        $debit_note->includeFirstLineDataCompany($client->full_name, $client->document);
        $debit_note->addLineToHead(config('invoice.company'));
        $debit_note->addLineToHead(config('invoice.rif'));

        $invoice->details->map(function ($invoice_detail) use ($debit_note) {
            if ($invoice_detail->productable_type == 'App\Models\ReceptionDetail') {
                $product = ReceptionDetail::find($invoice_detail->productable_id);
            }
            $debit_note->addProduct(
                $invoice_detail->price,
                $invoice_detail->quantity,
                $product->partial_min,
                'excent'
            );
        });
        $debit_note->applySubTotal();
        // $debit_note->applyTotal();

        return $debit_note->download('', (bool) $igtf);
    }
}
