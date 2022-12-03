<?php

namespace App\Http\Controllers\Repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Repair;
use App\Http\Resources\Repair\RepairResource;
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
                $repair = Repair::withTrashed()->get();
            }else{
                $repair = Repair::all();
            }
            return RepairResource::collection($repair);
        } catch (\Exception $e) {
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }
}
