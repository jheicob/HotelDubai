<?php

namespace App\Http\Controllers\Invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class DeleteController extends Controller
{

    public function destroy($invoice)
    {
         try {
            DB::beginTransaction();
            $invoice = Invoice::where('id', $invoice)->withTrashed()->first();

            if(!$invoice){
                return custom_response_error(422,'error-validation','Model no exist',422);
            }

            if (!$invoice->deleted_at) {
                $invoice->delete();
            } else {
                $invoice->restore();
            }

            DB::commit();

            return custom_response_sucessfull('deleted successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
