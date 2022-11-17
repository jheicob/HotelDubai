<?php

namespace App\Http\Controllers\ExtraGuest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ExtraGuest;
use App\Http\Resources\ExtraGuest\ExtraGuestResource;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        return view('ExtraGuest.index');
        // return ['view'];
    }

    public function get()
    {
        try {
            $extraguest = ExtraGuest::withTrashed()->get();

            return ExtraGuestResource::collection($extraguest);
        } catch (\Exception $e) {
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }
}
