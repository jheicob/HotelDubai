<?php

namespace App\Http\Controllers\Invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Http\Resources\Invoice\InvoiceResource;
use App\Models\ReceptionDetail;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        return view('Invoice.index');
    }

    public function get()
    {
        try {
            $invoice = Invoice::with([
                'client',
                'details'
            ])
                ->withTrashed()->get();

            $invoice->map(function ($invoic){
                $invoic->details->transform(function($detail){
                    if($detail->productable_type == 'App\Models\ReceptionDetail'){
                        $reception_detail = ReceptionDetail::find($detail->productable_id);
                    }
                    $detail['product_name'] = $reception_detail->partial_min;

                    return $detail;
                });
            });

            return InvoiceResource::collection($invoice);
        } catch (\Exception $e) {
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }
}
