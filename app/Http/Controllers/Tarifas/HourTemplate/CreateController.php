<?php

namespace App\Http\Controllers\Tarifas\HourTemplate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tarifas\HourTemplate\CreateRequest;
use Illuminate\Support\Facades\DB;
use App\Models\HourTemplate;
class CreateController extends Controller
{

    public function create(CreateRequest $request)
    {
        try {
            DB::beginTransaction();

            $hourtemplate = HourTemplate::create($request->all());

            DB::commit();

            return custom_response_sucessfull('created successfull',201);

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
