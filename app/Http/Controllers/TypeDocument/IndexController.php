<?php

namespace App\Http\Controllers\TypeDocument;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TypeDocument;
use App\Http\Resources\TypeDocument\TypeDocumentResource;
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
            if(isAdmin()){
                $typedocument = TypeDocument::withTrashed()->get();
            }else{
                $typedocument = TypeDocument::all();
            }
            return TypeDocumentResource::collection($typedocument);
        } catch (\Exception $e) {
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }
}
