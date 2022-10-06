<?php

namespace App\Http\Controllers\Tarifas\DayTemplate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DayTemplate;
use App\Http\Resources\Tarifas\DayTemplate\DayTemplateResource;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        return view('Tarifas.DayTemplate.index');
    }

    public function get()
    {
        try {
            $daytemplate = DayTemplate::with([
                'roomType',
                'dayWeek'
            ])->withTrashed()->get();

            return DayTemplateResource::collection($daytemplate);
        } catch (\Exception $e) {
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }
}
