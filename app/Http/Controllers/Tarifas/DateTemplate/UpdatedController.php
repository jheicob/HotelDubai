<?php

namespace App\Http\Controllers\Tarifas\DateTemplate;

use App\Http\Controllers\Controller;
use App\Http\Requests\RangeTemplateUpdateMasiveRequest;
use App\Http\Requests\Tarifas\DateTemplate\UpdateRequest;
use App\Models\DateTemplate;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UpdatedController extends Controller
{
    public function updated(UpdateRequest $request,DateTemplate $id)
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

    public function masiveUptade(RangeTemplateUpdateMasiveRequest $request){
        try {
            DB::beginTransaction();

            $dayTemplate = DateTemplate::find($request->day_template_id);

            $dayTemplate->map(function($item) use ($request){
                $item->update($request->only('rate'));
            });

            DB::commit();

            return custom_response_sucessfull('updated successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }

    }
}
