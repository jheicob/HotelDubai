<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        //return view('DateTemplate.index');
        return ['view'];
    }

    public function get()
    {
        try {
            $product = Product::withTrashed()->get();

            return ProductResource::collection($product);
        } catch (\Exception $e) {
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }
}
