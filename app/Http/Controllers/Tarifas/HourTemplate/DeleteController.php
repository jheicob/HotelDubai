<?php

namespace App\Http\Controllers\Tarifas\HourTemplate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HourTemplate;
use Illuminate\Support\Facades\DB;

class DeleteController extends Controller
{

    public function destroy($id)
    {
         try {
            DB::beginTransaction();
            $hourtemplate = HourTemplate::where('id', $id)->withTrashed()->first();

            if(!$hourtemplate){
                return custom_response_error(422,'error-validation','Model no exist',422);
            }

            if (!$hourtemplate->deleted_at) {
                $hourtemplate->delete();
            } else {
                $hourtemplate->restore();
            }

            DB::commit();

            return custom_response_sucessfull('deleted successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
