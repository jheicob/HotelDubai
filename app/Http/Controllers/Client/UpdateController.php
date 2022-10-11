<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\UpdateRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Client;

class UpdateController extends Controller
{

    public function updated(UpdateRequest $request, Client $client)
    {
        try {
            DB::beginTransaction();

            $client->update($request->all());

            DB::commit();

            return custom_response_sucessfull('updated successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
