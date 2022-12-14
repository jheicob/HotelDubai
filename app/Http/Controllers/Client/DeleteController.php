<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

class DeleteController extends Controller
{

    public function destroy($client)
    {
         try {
            DB::beginTransaction();
            $client = Client::where('id', $client)->withTrashed()->first();

            if(!$client){
                return custom_response_error(422,'error-validation','Model no exist',422);
            }

            if (!$client->deleted_at) {
                $client->delete();
            } else {
                $client->restore();
            }

            DB::commit();

            return custom_response_sucessfull('deleted successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
