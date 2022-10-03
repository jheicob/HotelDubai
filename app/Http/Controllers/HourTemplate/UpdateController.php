<?php

namespace App\Http\Controllers\HourTemplate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\HourTemplate\UpdateRequest;
use Illuminate\Support\Facades\DB;
use App\Models\HourTemplate;

class UpdateController extends Controller
{

    public function updated(UpdateRequest $request, HourTemplate $hourtemplate)
    {
        try {
            DB::beginTransaction();

            $hourtemplate->update($request->all());

            DB::commit();

            return custom_response_sucessfull('updated successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
