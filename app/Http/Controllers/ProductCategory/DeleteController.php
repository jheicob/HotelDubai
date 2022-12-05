<?php

namespace App\Http\Controllers\ProductCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;

class DeleteController extends Controller
{

    public function destroy($id)
    {
         try {
            DB::beginTransaction();
            $productcategory = ProductCategory::where('id', $id)->withTrashed()->first();

            if(!$productcategory){
                return custom_response_error(422,'error-validation','Model no exist',422);
            }

            if (!$productcategory->deleted_at) {
                $productcategory->delete();
            } else {
                $productcategory->restore();
            }

            DB::commit();

            return custom_response_sucessfull('deleted successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
