<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfigurationRequest;
use App\Http\Resources\ConfigurationResource;
use App\Models\Configuration;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ConfigurationController extends Controller
{
    public function view()
    {
        return view('Configuration.index');
    }

    public function index(Request $request)
    {
        $configuration = Configuration::first();

        return ConfigurationResource::make($configuration);
    }

    public function upSert(ConfigurationRequest $request)
    {
        try {
            DB::beginTransaction();
            $configuration = Configuration::first();

            $configuration->update($request->all());
            DB::commit();

            return response()->json(Response::HTTP_OK);
        } catch (\Exception $ex) {
            DB::rollBack();
            return custom_response_exception($ex,__('errors.server.title'),500);
        }
    }
}
