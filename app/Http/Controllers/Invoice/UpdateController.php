<?php

namespace App\Http\Controllers\Invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\UpdateRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;

class UpdateController extends Controller
{

    public function updated(UpdateRequest $request, Invoice $invoice)
    {
        try {
            DB::beginTransaction();

            $invoice->update($request->all());

            DB::commit();

            return custom_response_sucessfull('updated successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
