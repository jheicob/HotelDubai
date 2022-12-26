<?php

namespace App\Http\Controllers\Tarifas\PartialTemplate;

use App\Http\Controllers\Controller;
use App\Http\Resources\PartialTemplateResource;
use App\Models\PartialTemplate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;

class IndexController extends Controller
{
    public function index()
    {
        return view('PartialTemplate.index');
    }

    public function get()
    {
        try {
            $permissions = PartialTemplate::with([
                'roomType','partialRate','dayWeek','systemTime','shiftSystem','partialRate'
                ])->withTrashed()->get();
            return PartialTemplateResource::collection($permissions);
        } catch (ValidationException $ex) {
            return response()->json(
                [
                'data' => [
                    'title'  => $ex->getMessage(),
                    'errors' => collect($ex->errors())->flatten()
                ]
                ], Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (\Exception $ex) {
            return response()->json(
                [
                'data' => [
                    'code'        => $ex->getCode(),
                    'title'       => __('errors.server.title'),
                    'description' => $ex->getMessage(),
                ]
                ], Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
