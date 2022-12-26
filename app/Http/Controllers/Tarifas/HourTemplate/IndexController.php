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
        return view('Tarifas.HourTemplate.index');
    }

    public function get()
    {
        try {
            $hourtemplate = HourTemplate::with([
                'roomType','partialRate','shiftSystem'
                ])->withTrashed()->get();
            return HourTemplateResource::collection($hourtemplate);
        } catch (\Exception $e) {
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }
}
