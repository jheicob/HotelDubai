<?php

namespace App\Http\Controllers\ProductCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCategory\UpdateRequest;
use Illuminate\Support\Facades\DB;
use App\Models\ProductCategory;

class UpdateController extends Controller
{

    public function updated(UpdateRequest $request, ProductCategory $ProductCategory)
    {
        try {
            DB::beginTransaction();

            $ProductCategory->update($request->all());

            DB::commit();

            return custom_response_sucessfull('updated successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
