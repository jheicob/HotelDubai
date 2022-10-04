<?php

namespace App\Http\Controllers\Tarifas\HourTemplate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tarifas\HourTemplate\HourTemplateResource;

use App\Models\HourTemplate;

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
            $hourtemplate = HourTemplate::with(['roomType'])->withTrashed()->get();

            return HourTemplateResource::collection($hourtemplate);
        } catch (\Exception $e) {
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }
}
