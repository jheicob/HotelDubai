<?php

namespace App\Http\Controllers\Tarifas\DateTemplate;

use App\Http\Controllers\Controller;
use App\Http\Resources\DateTemplateResource;
use App\Http\Resources\PartialCostResource;
use App\Models\DateTemplate;
use App\Models\PartialCost;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;

class IndexController extends Controller
{
    public function index()
    {
        return view('Tarifas.DateTemplate.index');
    }

    public function get()
    {
        try {
            $dateTemplate = DateTemplate::with([
                'roomType',
                'partialRate'
                            ]);
            if(isAdmin()){
                $dateTemplate = $dateTemplate->withTrashed();
            }
            $dateTemplate = $dateTemplate->get();

            return DateTemplateResource::collection($dateTemplate);
        } catch (\Exception $e) {
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }
}
