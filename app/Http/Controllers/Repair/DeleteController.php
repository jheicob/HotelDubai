<?php

namespace App\Http\Controllers\Repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Repair;
use Illuminate\Support\Facades\DB;

class DeleteController extends Controller
{

    public function destroy($id)
    {
         try {
            DB::beginTransaction();
            $repair = Repair::where('id', $id)->withTrashed()->first();

            if(!$repair){
                return custom_response_error(422,'error-validation','Model no exist',422);
            }

            if (!$repair->deleted_at) {
                $repair->delete();
            } else {
                $repair->restore();
            }

            DB::commit();

            return custom_response_sucessfull('deleted successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
