<?php

namespace App\Http\Controllers\ExtraGuest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExtraGuest\UpdateRequest;
use Illuminate\Support\Facades\DB;
use App\Models\ExtraGuest;

class UpdateController extends Controller
{

    public function updated(UpdateRequest $request, ExtraGuest $extraguest)
    {
        try {
            DB::beginTransaction();

            $extraguest->update($request->all());

            DB::commit();

            return custom_response_sucessfull('updated successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
