<?php

namespace App\Http\Controllers\Tarifas\DateTemplate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tarifas\DateTemplate\CreateRequest;
use App\Models\DateTemplate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class CreateController extends Controller
{
    protected $model;

    public function __construct(DateTemplate $dateTemplate)
    {
        $this->model = $dateTemplate;
    }
    public function create(CreateRequest $request)
    {
        DB::beginTransaction();
        try {

            $this->model::create($request->all());

            DB::commit();

            return custom_response_sucessfull('created successfull',201);

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }
}
