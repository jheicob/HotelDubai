<?php

namespace App\Http\Controllers\RangeTemplate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RangeTemplate;
use Illuminate\Support\Facades\DB;

class DeleteController extends Controller
{

    public function destroy($id)
    {
         try {
            DB::beginTransaction();
            $rangetemplate = RangeTemplate::where('id', $id)->withTrashed()->first();

            if(!$rangetemplate){
                return custom_response_error(422,'error-validation','Model no exist',422);
            }

            if (!$rangetemplate->deleted_at) {
                $rangetemplate->delete();
            } else {
                $rangetemplate->restore();
            }

            DB::commit();

            return custom_response_sucessfull('deleted successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
