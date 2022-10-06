<?php

namespace App\Http\Controllers\Tarifas\DayTemplate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DayTemplate;
use Illuminate\Support\Facades\DB;

class DeleteController extends Controller
{

    public function destroy($id)
    {
         try {
            DB::beginTransaction();
            $daytemplate = DayTemplate::where('id', $id)->withTrashed()->first();

            if(!$daytemplate){
                return custom_response_error(422,'error-validation','Model no exist',422);
            }

            if (!$daytemplate->deleted_at) {
                $daytemplate->delete();
            } else {
                $daytemplate->restore();
            }

            DB::commit();

            return custom_response_sucessfull('deleted successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
