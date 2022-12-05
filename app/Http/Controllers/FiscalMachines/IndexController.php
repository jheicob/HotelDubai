<?php

namespace App\Http\Controllers\FiscalMachines;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FiscalMachine;
use App\Http\Resources\FiscalMachines\FiscalMachinesResource;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        return view('FiscalMachine.index');
        // return ['view'];
    }

    public function getPublic(Request $request){
        try {

            $fiscalmachines = FiscalMachine::filter($request)->get();

            return FiscalMachinesResource::collection($fiscalmachines);
        } catch (\Exception $e) {
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

    public function get()
    {
        try {

            $fiscalmachines = FiscalMachine::With('estateType');

            if(isAdmin()){
                $fiscalmachines = $fiscalmachines->withTrashed();
            }
            $fiscalmachines = $fiscalmachines->get();

            return FiscalMachinesResource::collection($fiscalmachines);
        } catch (\Exception $e) {
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }
}
