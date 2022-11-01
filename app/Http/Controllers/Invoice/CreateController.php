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
use App\Traits\Configurations\GeneralConfiguration;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CreateController extends Controller
{
    use GeneralConfiguration;
    protected $aum_neto;
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

            self::VerifiedAndUpdateAdditionalReceptionDetails($reception, $request->reception_details);
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
            $invoice->identify = config('invoice.local') . '-' . $invoice->id;
            $invoice->save();

            $reception->details->map(function ($item) use ($invoice) {
                $data = [
                    'price'      => $item->rate,
                    'quantity'   => $item->quantity_partial,
                    'invoice_id' => $invoice->id
                ];

                $item->invoiceDetail()->create($data);

                if ($item->time_additional) {
                    $quantity_aditional = (string) $item->time_additional;
                    $quantity_aditional = (int) rtrim($quantity_aditional, 'h');
                    $data2 = [
                        'price' => $item->price_additional,
                        'quantity' => $quantity_aditional,
                        'invoice_id' => $invoice->id,
                    ];
                    $item->invoiceDetail()->create($data2);
                }
            });

            self::storePayments($invoice, $request->payments);

            // $invoice_details = $invoice->details()->create()
            $reception->update(['invoiced' => true]);
            $roomStatus = \App\Models\RoomStatus::firstWhere('name', 'Sucia');
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

    /**
     * verified and update additionals for reception details
     */
    public function VerifiedAndUpdateAdditionalReceptionDetails(Reception $reception, array $details)
    {
        $reception_details = $reception->details;

        foreach ($details as $detail) {
            if ($detail['time_additional'] != 0) {
                ($reception_details->firstWhere('id', $detail['id']))
                    ->update([
                        'time_additional' => $detail['time_additional'],
                        'price_additional' => $detail['price_additional'],
                        'observation' => $detail['observation'],
                    ]);
            }
        }
    }

    /**
     * create payments for invoice
     *
     * @param Invoice $invoice
     * @param array $payments
     * @return void
     */
    private function storePayments(Invoice $invoice, array $payments)
    {
        $acum = 0;
        foreach ($payments as $payment) {
            $acum += $payment['quantity'];
            $invoice->payments()->create($payment);
        }
        $invoice->update(['total_payment' => $acum]);
    }

    public function printFiscal(Invoice $invoice, Request $request)
    {
        DB::beginTransaction();
        try {
            $igtf = $request->igtf == 'true' ? true : false;
            $isCancel = $request->isCancel == 'true' ? true : false;
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
        $debit_note->setInvoiceId($invoice->identify);
        $debit_note->includeFirstLineDataCompany($full_name, $document);

        $invoice->details->map(function ($invoice_detail) use ($debit_note) {
            if ($invoice_detail->productable_type == 'App\Models\ReceptionDetail') {
                $product = ReceptionDetail::find($invoice_detail->productable_id);
            }

            $iva = 0.16;
            $precio = self::calculatePriceOfProduct($invoice_detail);

            $name_product = $product->reception->observation . ' ' . $product->partial_min;

            $debit_note->addProduct(
                $precio,
                $invoice_detail->quantity,
                $name_product,
                $iva * 100
            );
        });
        $debit_note->applySubTotal();
        // $debit_note->applyTotal();
        $invoice->update(['status' => 'Impreso']);
        DB::commit();
        return $debit_note->download('', self::sumPaymentInDivisa($invoice));
    }

    private function calculatePriceOfProduct($invoice_detail)
    {
        $iva = 0.16;
        //           Log::info('------producto nuevo------');
        $cantidad = $invoice_detail->quantity;
        //         Log::info('cantidad:'.$cantidad);
        $total = $invoice_detail->price * $cantidad;
        //       Log::info('total:'.$total);
        $precio = round(($total / (1 + $iva)), 2);
        //     Log::info('precio sin iva:'.$precio);
        //   Log::info('---------------------------');
        $this->acum_neto += $precio;

        return $precio;
    }

    /**
     * create a credit note
     */
    private function createCreditNote(Invoice $invoice, $full_name, $document, $igtf)
    {
        $debit_note = new CreditNoteService();
        $debit_note->setInvoiceId($invoice->identify);
        $debit_note->includeFirstLineDataCompanyForCN($full_name, $document, $invoice, $this->getFiscalMachineSerial());

        $invoice->details->map(function ($invoice_detail) use ($debit_note) {
            if ($invoice_detail->productable_type == 'App\Models\ReceptionDetail') {
                $product = ReceptionDetail::find($invoice_detail->productable_id);
            }

            $iva = 0.16;
            $precio = self::calculatePriceOfProduct($invoice_detail);

            $name_product = $product->reception->observation . ' ' . $product->partial_min;

            $debit_note->addProduct(
                $precio,
                $invoice_detail->quantity,
                $name_product,
                $iva * 100
            );
        });
        $debit_note->applySubTotal();
        // $debit_note->applyTotal();
        $invoice->update([
            'status' => 'Cancelada',
            'cancelled' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::commit();

        return $debit_note->download('', self::sumPaymentInDivisa($invoice));
    }

    private function sumPaymentInDivisa(Invoice $invoice): float
    {
        $payments = $invoice->payments->where('type', 'divisa');
        $sum = 0;
        if ($payments->count() > 0) {
            $sum = $payments->sum('quantity');
            return round(($sum / 1.03), 2); // el 3% del igtf 103
        }
        //       return $payments->sum('quantity');
        return 0;
    }
}
