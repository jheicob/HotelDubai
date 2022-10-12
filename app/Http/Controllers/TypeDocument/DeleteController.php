<?php

namespace App\Http\Controllers\TypeDocument;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TypeDocument;
use Illuminate\Support\Facades\DB;

class DeleteController extends Controller
{

    public function destroy($id)
    {
         try {
            DB::beginTransaction();
            $typedocument = TypeDocument::where('id', $id)->withTrashed()->first();

            if(!$typedocument){
                return custom_response_error(422,'error-validation','Model no exist',422);
            }

            if (!$typedocument->deleted_at) {
                $typedocument->delete();
            } else {
                $typedocument->restore();
            }

            DB::commit();

            return custom_response_sucessfull('deleted successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
