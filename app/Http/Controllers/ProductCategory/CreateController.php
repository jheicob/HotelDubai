<?php

namespace App\Http\Controllers\ProductCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCategory\CreateRequest;
use Illuminate\Support\Facades\DB;
use App\Models\ProductCategory;
class CreateController extends Controller
{

    public function create(CreateRequest $request)
    {
        try {
            DB::beginTransaction();

            $productcategory = ProductCategory::create($request->all());

            DB::commit();

            return custom_response_sucessfull('created successfull',201);

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
