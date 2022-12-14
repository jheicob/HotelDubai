<?php

namespace App\Http\Controllers\Invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Http\Resources\Invoice\InvoiceResource;
use App\Models\Product;
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
                'details',
                'payments'
            ])
                ->orderBy('id', 'desc');
            if(isAdmin()){
                $invoice = $invoice->withTrashed();
            }
            $invoice = $invoice->get();

            return InvoiceResource::collection($invoice);
        } catch (\Exception $e) {
            return custom_response_exception($e, __('errors.server.title'), 500);
        }
    }
}
