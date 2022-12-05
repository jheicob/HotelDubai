<?php

namespace App\Http\Controllers\FiscalMachines;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FiscalMachines\CreateRequest;
use Illuminate\Support\Facades\DB;
use App\Models\FiscalMachine;
class CreateController extends Controller
{

    public function create(CreateRequest $request)
    {
        try {
            DB::beginTransaction();

            $fiscalmachines = FiscalMachine::create($request->all());

            DB::commit();

            return custom_response_sucessfull('created successfull',201);

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
