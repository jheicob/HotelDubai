<?php

namespace App\Http\Controllers\FiscalMachines;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FiscalMachine;
use Illuminate\Support\Facades\DB;

class DeleteController extends Controller
{

    public function destroy($id)
    {
         try {
            DB::beginTransaction();
            $fiscalmachines = FiscalMachine::where('id', $id)->withTrashed()->first();

            if(!$fiscalmachines){
                return custom_response_error(422,'error-validation','Model no exist',422);
            }

            if (!$fiscalmachines->deleted_at) {
                $fiscalmachines->delete();
            } else {
                $fiscalmachines->restore();
            }

            DB::commit();

            return custom_response_sucessfull('deleted successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
