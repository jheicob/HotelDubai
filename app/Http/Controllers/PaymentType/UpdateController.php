<?php

namespace App\Http\Controllers\PaymentType;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentType\UpdateRequest;
use Illuminate\Support\Facades\DB;
use App\Models\PaymentType;

class UpdateController extends Controller
{

    public function updated(UpdateRequest $request, PaymentType $paymenttype)
    {
        try {
            DB::beginTransaction();

            $paymenttype->update($request->all());

            DB::commit();

            return custom_response_sucessfull('updated successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
