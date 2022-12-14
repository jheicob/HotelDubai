<?php

namespace App\Http\Controllers\ProductCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Http\Resources\ProductCategory\ProductCategoryResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        return view('ProductCategory.index');
        // return ['view'];
    }

    public function get(Request $request)
    {
        try {
            $productcategory = ProductCategory::with('products')
                ->when($request->slash_code,function(Builder $q,$slash_code){
                    $q->whereHas('products', function(Builder $q) use ($slash_code){
                        $q->where('slash_code',$slash_code);
                    });
                });
            ;
            if(isAdmin()){
                $productcategory = $productcategory->withTrashed();
            }

            $productcategory = $productcategory->get();

            return ProductCategoryResource::collection($productcategory);
        } catch (\Exception $e) {
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }
}
