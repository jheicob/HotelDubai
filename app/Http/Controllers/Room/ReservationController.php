<?php

namespace App\Http\Controllers\Room;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Http\Resources\Room\RoomResource;
use App\Models\Reception;
use App\Services\RoomService\RoomService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
   public function cancelarReservacion(Reception $reception){
    try {
        DB::beginTransaction();

        $reception->details->map(function ($detail) {
            $detail->ticket->delete();
            $detail->delete();
        });
        $invoice = $reception->invoice;
        $invoice->details->map(function ($detail) {
            $detail->delete();
        });

        $reception->companions->map(function ($companion) {
            $companion->delete();
        });
        $invoice->delete();
        $reception->delete();
        DB::commit();
        return custom_response_sucessfull('cancel successfull', 200);
    } catch (\Exception $e) {
        DB::rollBack();
        return custom_response_exception($e, __('errors.server.title'), 500);
    }
   }
}
