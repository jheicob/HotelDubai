<?php

namespace App\Http\Controllers\RangeTemplate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RangeTemplate;
use App\Http\Resources\RangeTemplate\RangeTemplateResource;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        return view('Tarifas.RangeTemplate.index');
        // return ['view'];
    }

    public function get()
    {
        try {
            $rangetemplate = RangeTemplate::withTrashed()
                ->with([
                    'partialRate',
                    'roomType'
                ])
                ->get();

            return RangeTemplateResource::collection($rangetemplate);
        } catch (\Exception $e) {
            return custom_response_exception($e, __('errors.server.title'), 500);
        }
    }
}
