<?php

namespace App\Http\Controllers\Room;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class DeleteController extends Controller
{

    public function destroy($room)
    {
         try {
            DB::beginTransaction();
            $room = Room::where('id', $room)->withTrashed()->first();

            if(!$room){
                return custom_response_error(422,'error-validation','Model no exist',422);
            }

            if (!$room->deleted_at) {
                $room->delete();
            } else {
                $room->restore();
            }

            DB::commit();

            return custom_response_sucessfull('deleted successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

}
