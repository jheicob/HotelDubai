<?php

namespace App\Http\Controllers\RangeTemplate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RangeTemplate\UpdateRequest;
use Illuminate\Support\Facades\DB;
use App\Models\RangeTemplate;

class UpdateController extends Controller
{

    public function updated(UpdateRequest $request, RangeTemplate $rangetemplate)
    {
        try {
            DB::beginTransaction();

            $rangetemplate->update($request->all());

            DB::commit();

            return custom_response_sucessfull('updated successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
