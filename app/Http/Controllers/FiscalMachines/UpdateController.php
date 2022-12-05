<?php

namespace App\Http\Controllers\FiscalMachines;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FiscalMachines\UpdateRequest;
use Illuminate\Support\Facades\DB;
use App\Models\FiscalMachine;

class UpdateController extends Controller
{

    public function updated(UpdateRequest $request, FiscalMachine $FiscalMachines)
    {
        try {
            DB::beginTransaction();

            $FiscalMachines->update($request->all());

            DB::commit();

            return custom_response_sucessfull('updated successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
