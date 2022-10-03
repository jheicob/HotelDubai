<?php

namespace App\Http\Controllers\Tarifas\DateTemplate;

use App\Http\Controllers\Controller;
use App\Models\DateTemplate;
use App\Models\PartialCost;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class DeleteController extends Controller
{
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $dateTemplate = DateTemplate::where('id', $id)->withTrashed()->first();

            if(!$dateTemplate){
                return custom_response_error(422,'error-validation','Model no exist',422);
            }

            if (!$dateTemplate->deleted_at) {
                $dateTemplate->delete();
            } else {
                $dateTemplate->restore();
            }

            DB::commit();

            return custom_response_sucessfull('deleted successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }
}
