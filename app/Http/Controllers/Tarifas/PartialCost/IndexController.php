<?php

namespace App\Http\Controllers\Tarifas\PartialCost;

use App\Http\Controllers\Controller;
use App\Http\Resources\PartialCostResource;
use App\Models\PartialCost;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;

class IndexController extends Controller
{
    public function index()
    {
        return view('PartialCost.index');
    }

    public function get(Request $request)
    {
        try {
            $permissions = PartialCost::with(['roomType','partialRate'])
                            ->filter($request)
                            ;
            if(isAdmin()){
                $permissions = $permissions->withTrashed();
            }
            $permissions = $permissions->get();
            return PartialCostResource::collection($permissions);
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
