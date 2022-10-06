<?php

namespace App\Http\Controllers\Tarifas\DayTemplate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tarifas\DayTemplate\UpdateRequest;
use Illuminate\Support\Facades\DB;
use App\Models\DayTemplate;

class UpdateController extends Controller
{

    public function updated(UpdateRequest $request, DayTemplate $daytemplate)
    {
        try {
            DB::beginTransaction();

            $daytemplate->update($request->all());

            DB::commit();

            return custom_response_sucessfull('updated successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
