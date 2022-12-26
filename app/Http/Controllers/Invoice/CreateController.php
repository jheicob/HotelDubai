<?php

namespace App\Http\Controllers\Invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\CreateRequest;
use App\Models\Client;
use App\Models\ExtraGuest;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Product;
use App\Models\Reception;
use App\Models\ReceptionDetail;
use App\Services\FiscalInvoice\DebitNoteService;
use App\Services\FiscalInvoice\CreditNoteService;
use App\Services\FiscalInvoice\FiscalInvoiceService;
use App\Services\Invoice\InvoiceService;
use App\Traits\Configurations\GeneralConfiguration;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CreateController extends Controller
{
    use GeneralConfiguration;
    protected $acum_neto;
    protected $service;

    public function __construct(InvoiceService $service)
    {
        $this->service = $service;
    }

    public function ventas(){
        return view('Invoice.create');
    }
    public function create(CreateRequest $request)
    {
        try {
            DB::beginTransaction();
            Log::info('creando factura');
            $client = Client::find($request->client_id);
            $reception = false;
            $total_invoice = 0;

            if($request->reception_details && count($request->reception_details) > 0 ) {
                $reception = Reception::where([
                    ['client_id',$request->client_id],
                    ['room_id',$request->room_id]
                ])->first();

                self::VerifiedAndUpdateAdditionalReceptionDetails($reception, $request->reception_details);
                $total_invoice += $this->service->calculateTotalByReceptionDetails($reception);
            }

            if($request->products && count($request->products) > 0 ) {
                $total_invoice += self::getTotalAcumOfProducts($request->products);
            }

            $request->merge([
                'total' => $total_invoice,
                'date'  => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            if($reception && $reception->invoice && count($request->reception_details) > 0) {
                $invoice = $reception->invoice;
                $invoice->update(($request->only('total','fiscal_machine_id')));
            }else{
                $data = $request->has('fiscal_machine_id') ? $request->only([
                    'client_id',
                    'total',
                    'observation',
                    'date',
                    'fiscal_machine_id'
                ]) : $request->only([
                    'client_id',
                    'total',
                    'observation',
                    'date'
                ]);
                Log::info('creando factura con datos');
                Log::info($data);
                $invoice = Invoice::create($data);
            }

            $invoice->identify = config('invoice.local') . '-' . $invoice->id;
            $invoice->save();

            if($request->reception_details && count($request->reception_details) > 0) {
                $reception = Reception::where([
                    ['client_id',$request->client_id],
                    ['room_id',$request->room_id]
                ])->first();

                $reception->invoice_id = $invoice->id;
                $reception->save();

                self::storeReceptionDetailsInInvoice($reception, $invoice);
            }
            if($request->products && count($request->products) > 0 ) {
                self::storeProductsInInvoice($invoice, $request->products);
            }
            if($request->click_in_invoice){
                $reception->update(['invoiced' => true,'invoice_id' => $invoice->id]);
                $invoice->update(['date' => $reception->date_out]);
                $roomStatus = \App\Models\RoomStatus::firstWhere('name', 'Sucia');
                $reception->room->update(['room_status_id' => $roomStatus->id]);

            }

            self::storePayments($invoice, $request->payments);

            // $invoice_details = $invoice->details()->create()

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
            if(!array_key_exists('id',$payment)){
                $acum += $payment['quantity'];
                $invoice->payments()->create($payment);
            }
        }
        $invoice->update(['total_payment' => $acum]);
    }

    public function printFiscal(Invoice $invoice, Request $request)
    {
        DB::beginTransaction();
        try {
            Log::info('imprimientod');
            $igtf = $request->igtf == 'true' ? true : false;
            $isCancel = $request->isCancel == 'true' ? true : false;

            Log::info($request->all());
            $client = $invoice->client;
            $client->append('full_name');

            if($request->chan == 'false'){
                if ($isCancel) {
                    return self::createCreditNote($invoice, $client->full_name, $client->document, $igtf);
                } else{
                    return self::createDebitNote($invoice, $client->full_name, $client->document, $igtf);
                }
            }

            $invoice->update(['chanchuyo'=>1]);
            $invoice->update(['status' => 'Impreso']);

            DB::commit();
            return ;
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

            $name_product = 'hab'.$product->reception->room->name . ' ' . $product->partial_min;
            }else
            if($invoice_detail->productable_type == 'App\Models\Product')
            {
                $product = \App\Models\Product::find($invoice_detail->productable_id);

            $name_product = $product->name;
            }else{

                $name_product = $invoice_detail->description;
            }

            $iva = 0.16;
            $precio = self::calculatePriceOfProduct($invoice_detail);


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
        $total = $invoice->total;

        if ($payments->count() > 0) {
            $sum = $payments->sum('quantity');
            if($sum > $invoice->total){
                return $invoice->total;
            }
            return $sum;
            // return round(($sum / 1.03), 2); // el 3% del igtf 103
        }
        //       return $payments->sum('quantity');
        return 0;
    }

    public function reportX(Request $request)
    {
        $fiscal = new FiscalInvoiceService();

        return $fiscal->reportX();
    }

    public function reportZ(Request $request)
    {
        $fiscal = new FiscalInvoiceService();

        return $fiscal->reportZ();
    }

    private function storeProductsInInvoice(Invoice $invoice, $products)
    {
        foreach ($products as $product) {
            if($product['type'] == 'InvoiceDetail') {
                continue;
            }
            if($product['type'] == 'Product'){
                $prod = Product::find($product['id']);
                $data = [
                    'price'      => $prod->sale_price,
                    'quantity'   => $quantity = $product['quantity'],
                    'invoice_id' => $invoice->id,
                    'description' => $prod->name,
                ];
                $prod->invoiceDetail()->create($data);

                $prod->inventory->stock -= $quantity;
                if ($prod->inventory->stock < 0) {
                    throw new \Exception('El producto ' . $prod->name . ' No tiene stock en su Inventario');
                }
                $prod->inventory->save();
            }
            if($product['type'] == 'ExtraGuest'){
                $prod = ExtraGuest::find($product['id']);
                $data = [
                    'price'      => $prod->rate,
                    'quantity'   => $quantity = $product['quantity'],
                    'invoice_id' => $invoice->id,
                    'description' => $product['description'].'-'.$prod->name,

                ];
                $prod->invoiceDetail()->create($data);
            }
            if($product['type'] == ''){
                $data = [
                    'price'      => $product['price'],
                    'quantity'   => $quantity = $product['quantity'],
                    'invoice_id' => $invoice->id,
                    'description' => $product['description'],
                ];
                InvoiceDetail::create($data);
            }
        }
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

    private function getTotalAcumOfProducts($products): float
    {
        $acum = 0;

        foreach($products as $product){
            $acum += $product['price'] * $product['quantity'];
        }
        return $acum;

    }
}
