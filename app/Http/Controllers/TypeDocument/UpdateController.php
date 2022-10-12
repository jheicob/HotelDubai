<?php

namespace App\Http\Controllers\TypeDocument;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TypeDocument\UpdateRequest;
use Illuminate\Support\Facades\DB;
use App\Models\TypeDocument;

class UpdateController extends Controller
{

    public function updated(UpdateRequest $request, TypeDocument $typedocument)
    {
        try {
            DB::beginTransaction();

            $typedocument->update($request->all());

            DB::commit();

            return custom_response_sucessfull('updated successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
