<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UpdateRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class UpdateController extends Controller
{

    public function updated(UpdateRequest $request, Product $product)
    {
        try {
            DB::beginTransaction();

            $product->update($request->all());

            DB::commit();

            return custom_response_sucessfull('updated successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
