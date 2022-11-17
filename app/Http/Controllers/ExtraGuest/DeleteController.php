<?php

namespace App\Http\Controllers\ExtraGuest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ExtraGuest;
use Illuminate\Support\Facades\DB;

class DeleteController extends Controller
{

    public function destroy($id)
    {
         try {
            DB::beginTransaction();
            $extraguest = ExtraGuest::where('id', $id)->withTrashed()->first();

            if(!$extraguest){
                return custom_response_error(422,'error-validation','Model no exist',422);
            }

            if (!$extraguest->deleted_at) {
                $extraguest->delete();
            } else {
                $extraguest->restore();
            }

            DB::commit();

            return custom_response_sucessfull('deleted successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
