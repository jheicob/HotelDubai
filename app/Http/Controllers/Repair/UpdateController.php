<?php

namespace App\Http\Controllers\Repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Repair\UpdateRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Repair;

class UpdateController extends Controller
{

    public function updated(UpdateRequest $request, Repair $repair)
    {
        try {
            DB::beginTransaction();

            $repair->update($request->all());

            DB::commit();

            return custom_response_sucessfull('updated successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
