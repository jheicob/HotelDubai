<?php

namespace App\Http\Controllers\HourTemplate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HourTemplate;
use App\Http\Resources\HourTemplate\HourTemplateResource;

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
            $hourtemplate = HourTemplate::withTrashed()->get();

            return HourTemplateResource::collection($hourtemplate);
        } catch (\Exception $e) {
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }
}
