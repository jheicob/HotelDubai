<?php

namespace App\Http\Controllers\Tarifas\HourTemplate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tarifas\HourTemplate\UpdateRequest;
use Illuminate\Support\Facades\DB;
use App\Models\HourTemplate;

class UpdateController extends Controller
{

    public function updated(UpdateRequest $request, HourTemplate $id)
    {
        try {
            DB::beginTransaction();
            $id->update($request->all());

            DB::commit();

            return custom_response_sucessfull('updated successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
