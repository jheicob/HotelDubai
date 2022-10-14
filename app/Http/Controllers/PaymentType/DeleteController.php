<?php

namespace App\Http\Controllers\PaymentType;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PaymentType;
use Illuminate\Support\Facades\DB;

class DeleteController extends Controller
{

    public function destroy($id)
    {
         try {
            DB::beginTransaction();
            $paymenttype = PaymentType::where('id', $id)->withTrashed()->first();

            if(!$paymenttype){
                return custom_response_error(422,'error-validation','Model no exist',422);
            }

            if (!$paymenttype->deleted_at) {
                $paymenttype->delete();
            } else {
                $paymenttype->restore();
            }

            DB::commit();

            return custom_response_sucessfull('deleted successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
