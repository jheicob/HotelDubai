<?php

namespace App\Http\Controllers\PaymentType;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PaymentType;
use App\Http\Resources\PaymentType\PaymentTypeResource;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        //return view('DateTemplate.index');
        return ['view'];
    }

    public function get()
    {
        try {
            $paymenttype = PaymentType::withTrashed()->get();

            return PaymentTypeResource::collection($paymenttype);
        } catch (\Exception $e) {
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }
}
