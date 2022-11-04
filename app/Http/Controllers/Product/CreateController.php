<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class CreateController extends Controller
{

    public function create(CreateRequest $request)
    {
        try {
            DB::beginTransaction();

            $product = Product::create($request->all());
            $product->inventory()->create($request->inventory);
            DB::commit();

            return custom_response_sucessfull('created successfull', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e, __('errors.server.title'), 500);
        }
    }
}
