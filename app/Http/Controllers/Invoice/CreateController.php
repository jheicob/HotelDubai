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
use App\Services\FiscalInvoice\CreditNoteService;
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
        DB::beginTransaction();
        try {
            $igtf = $request->igtf == 'true' ? true : false;
            $isCancel = $request->isCancel == 'true' ? true : false;

            if ($invoice->cancelled && $isCancel) {
                return custom_response_error(
                    422,
                    'Validation error',
                    'No se puede volver a cancelar una Factura',
                    422
                );
            }

            if ($invoice->status == 'Impreso' && !$isCancel) {
                return custom_response_error(
                    422,
                    'Validation error',
                    'La Factura ya está impresa, contacte con el administrador',
                    422
                );
            }

            // return ';';
            $client = $invoice->client;
            $client->append('full_name');

            if ($isCancel) {
                return self::createCreditNote($invoice, $client->full_name, $client->document, $igtf);
            } else {
                return self::createDebitNote($invoice, $client->full_name, $client->document, $igtf);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e, __('errors.server.title'));
        }
    }

    /**
     * create a debit note
     */
    private function createDebitNote(Invoice $invoice, $full_name, $document, $igtf)
    {
        $debit_note = new DebitNoteService();
        $debit_note->includeFirstLineDataCompany($full_name, $document);
        $debit_note->addLineToHead(config('invoice.company'));
        $debit_note->addLineToHead(config('invoice.rif'));
        $debit_note->addComment('Factura Fiscal');

        $invoice->details->map(function ($invoice_detail) use ($debit_note) {
            if ($invoice_detail->productable_type == 'App\Models\ReceptionDetail') {
                $product = ReceptionDetail::find($invoice_detail->productable_id);
            }
            $debit_note->addProduct(
                $invoice_detail->price,
                $invoice_detail->quantity,
                $product->partial_min
            );
        });
        $debit_note->applySubTotal();
        // $debit_note->applyTotal();
        $invoice->update(['status' => 'Impreso']);
        DB::commit();
        return $debit_note->download('', (bool) $igtf);
    }

    /**
     * create a credit note
     */
    private function createCreditNote(Invoice $invoice, $full_name, $document, $igtf)
    {
        $debit_note = new CreditNoteService();
        $debit_note->includeFirstLineDataCompanyForCN($full_name, $document, $invoice, 'ASZ-129');
        $debit_note->addLineToHead(config('invoice.company'));
        $debit_note->addLineToHead(config('invoice.rif'));
        $debit_note->addComment('Devolución de Factura Fiscal');

        $invoice->details->map(function ($invoice_detail) use ($debit_note) {
            if ($invoice_detail->productable_type == 'App\Models\ReceptionDetail') {
                $product = ReceptionDetail::find($invoice_detail->productable_id);
            }
            $debit_note->addProduct(
                $invoice_detail->price,
                $invoice_detail->quantity,
                $product->partial_min
            );
        });
        $debit_note->applySubTotal();
        // $debit_note->applyTotal();
        $invoice->update([
            'status' => 'Impreso',
            'cancelled' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::commit();

        return $debit_note->download('', (bool) $igtf);
    }
}
