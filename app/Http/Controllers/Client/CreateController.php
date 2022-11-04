<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\AssignRoomRequest;
use App\Http\Requests\Client\CreateRequest;
use App\Http\Requests\Client\InvoiceReceptionRequest;
use App\Http\Resources\Client\ClientResource;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\Reception;
use App\Models\Room;
use App\Models\RoomStatus;
use App\Services\RoomService\RoomService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Client\CancelUseRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Mpdf\Mpdf;

class CreateController extends Controller
{

    public function create(CreateRequest $request)
    {
        try {
            DB::beginTransaction();

            $client = Client::updateOrCreate(
                $request->only('document'),
                $request->except('document')
            );

            DB::commit();
            return ClientResource::make($client);
            // return custom_response_sucessfull('created successfull',201);

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e, __('errors.server.title'), 500);
        }
    }

    public function assigned_room(AssignRoomRequest $request)
    {
        try {
            DB::beginTransaction();

            $client = Client::find($request->client_id);
            $room = Room::find($request->room_id);

            $partial_rate = $room->partialCost->partialRate;
            $partial_rate->append('number_hour');

            $room_service = (new RoomService($room));
            $rate = $room_service->getRateByConditionals();
            $partialCost_new = $room_service->getPartialByConditionals();
            $partial_rate_new = \App\Models\PartialCost::find($partialCost_new)->partialRate->name;

            $quantity_total_hours = $request->quantity_partial * $partial_rate->number_hour;

            $request->merge([
                'date_out' => Carbon::parse($request->date_in)->addHours($quantity_total_hours),
                'partial_min' => $partial_rate_new,
                'rate' => $rate,
            ]);

            $reception = self::verifiedReceptionActive($client);
            if ($reception) {
                return self::extendReception($reception, $request, $quantity_total_hours);
            }

            $reception = $client->receptions()->create($request->only([
                'room_id',
                'date_in',
                'date_out',
                'observation'
            ]));

            $reception_detail = $reception->details()->create($request->only([
                'partial_min',
                'rate',
                'observation',
                'quantity_partial',
            ]));


            $reception_detail->ticket()->create([
                'observation' => $request->ticket_op
            ]);
            // $status = $request->date_in > Carbon::now() ? 'Reservada' : 'Ocupada';
            $roomStatus = RoomStatus::firstWhere('name', 'Ocupada');
            $room->update([
                'room_status_id' => $roomStatus->id,
            ]);
            DB::commit();
            return custom_response_sucessfull('created successfull', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e, __('errors.server.title'), 500);
        }
    }

    public function CancelUse(Client $client, CancelUseRequest $request)
    {
        try {
            DB::beginTransaction();

            $reception = $client->receptionActive->first();

            $reception->details->map(function ($detail) {
                $detail->delete();
            });

            $room = $reception->room;
            $room->update(['room_status_id' => 2]);
            $reception->delete();
            DB::commit();
            return custom_response_sucessfull('cancel successfull', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e, __('errors.server.title'), 500);
        }
    }

    public function verifiedReceptionActive(Client $client)
    {

        if (!$client->receptionActive->first()) {
            return false;
        }
        return $client->receptionActive->first();
    }

    public function extendReception(Reception $reception, Request $request, int $quantity_total_hours): JsonResponse
    {
        $reception->update([
            'date_out' => Carbon::parse($reception->date_out)->addHours($quantity_total_hours),
            'observation' => $request->observation
        ]);
        $reception_detail = $reception->details()->create($request->only([
            'partial_min',
            'rate',
            'observation',
            'quantity_partial',
        ]));
        $reception_detail->ticket()->create([
            'observation' => $request->ticket_op
        ]);
        DB::commit();
        return custom_response_sucessfull('update_successfull');
    }

    public function extendUse(Request $request)
    {
        try {
            DB::beginTransaction();

            $client = Client::find($request->client);

            $reception = $client->receptionActive->first();
            /*$client->roomActive->map(function($room){
                $room->invoiced = true;
                $room->pivot->save();
            });*/

            $room = Room::find($request->room_id);

            $partial_rate = $room->partialCost->partialRate;

            $partial_rate->append('number_hour');
            $quantity_total_hours = $request->quantity_partial * $partial_rate->number_hour;
            $request->merge([
                'date_out' => Carbon::parse($request->date_in)->addHours($quantity_total_hours),
                'partial_min' => $partial_rate->name,
                'rate' => $room->partialCost->rate,
            ]);

            $client->rooms()->attach($request->room_id, $request->except(['client_id', 'room_id']));

            $roomStatus = RoomStatus::firstWhere('name', 'Ocupada');
            $room->update([
                'room_status_id' => $roomStatus->id,
            ]);
            DB::commit();
            return custom_response_sucessfull('created successfull', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e, __('errors.server.title'), 500);
        }
    }

    public function invoiceReception(InvoiceReceptionRequest $request)
    {
        DB::beginTransaction();

        try {

            DB::commit();
            return custom_response_sucessfull('invoice create');
        } catch (\Exception $e) {
            DB::rollBack();

            return custom_response_exception($e, __('errors.server.title'), 500);
        }
    }

    public function createTicket(Request $request)
    {
        $pdf = new Mpdf(['mode' => 'utf-8', 'format' => [58, 80]]);

        $room = Room::find($request->room_id);
        $rate = (new \App\Services\RoomService\RoomService($room));
        $room->append('rate_current');
        $room->rate_current = $rate->getRateByConditionals();
        $room->partial_cost_id = $rate->getPartialByConditionals();

        $reception = $room->receptionActive->first();
        $reception_detail = $reception->details()->orderBy('created_at', 'desc')->first();
        $html = view('Ticket.Create', [
            'reception' => $reception,
            'ticket'    => $reception_detail->ticket,
            'total'     => $reception_detail->quantity_partial * $reception_detail->rate
        ]);
        // return $html;
        $pdf->WriteHTML($html);
        $nombre_archivo = 'Ticket';
        header('Content-Type: application/pdf');
        header("Content-Disposition: inline; filename='$nombre_archivo.pdf'");
        return $pdf->Output("$nombre_archivo.pdf", 'I');
    }
}
