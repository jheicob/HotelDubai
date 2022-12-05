<?php

namespace App\Http\Controllers\ProductCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Http\Resources\ProductCategory\ProductCategoryResource;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        return view('ProductCategory.index');
        // return ['view'];
    }

    public function get()
    {
        try {
            if(isAdmin()){
                $productcategory = ProductCategory::withTrashed()->get();
            }else{
                $productcategory = ProductCategory::all();

            }

            return ProductCategoryResource::collection($productcategory);
        } catch (\Exception $e) {
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }
}
