<?php

namespace App\Http\Controllers\RangeTemplate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RangeTemplate\UpdateRequest;
use App\Http\Requests\RangeTemplateUpdateMasiveRequest;
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

    public function masiveUptade(RangeTemplateUpdateMasiveRequest $request){
        try {
            DB::beginTransaction();

            $dayTemplate = RangeTemplate::find($request->day_template_id);

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
