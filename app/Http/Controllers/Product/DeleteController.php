<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DeleteController extends Controller
{

    public function destroy($id)
    {
         try {
            DB::beginTransaction();
            $product = Product::where('id', $id)->withTrashed()->first();

            if(!$product){
                return custom_response_error(422,'error-validation','Model no exist',422);
            }

            if (!$product->deleted_at) {
                $product->delete();
            } else {
                $product->restore();
            }

            DB::commit();

            return custom_response_sucessfull('deleted successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
