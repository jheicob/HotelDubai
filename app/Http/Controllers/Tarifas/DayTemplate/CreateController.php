<?php

namespace App\Http\Controllers\Tarifas\DayTemplate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tarifas\DayTemplate\CreateRequest;
use Illuminate\Support\Facades\DB;
use App\Models\DayTemplate;
class CreateController extends Controller
{

    public function create(CreateRequest $request)
    {
        try {
            DB::beginTransaction();

            $daytemplate = DayTemplate::create($request->all());

            DB::commit();

            return custom_response_sucessfull('created successfull',201);

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
