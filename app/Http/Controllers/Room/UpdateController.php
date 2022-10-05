<?php

namespace App\Http\Controllers\Room;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Room\UpdateRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Room;

class UpdateController extends Controller
{

    public function updated(UpdateRequest $request, Room $room)
    {
        try {
            DB::beginTransaction();

            $room->update($request->all());

            DB::commit();

            return custom_response_sucessfull('updated successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
