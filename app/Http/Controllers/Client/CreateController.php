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
use App\Http\Requests\Client\TransferRoomRequest;
use App\Models\Invoice;
use App\Models\Repair;
use App\Models\TransferRoom;
use App\Services\FiscalInvoice\NotFiscalDocument;
use App\Traits\Configurations\GeneralConfiguration;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Mpdf\Mpdf;

class CreateController extends Controller
{

    use GeneralConfiguration;
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
            Log::info('as');
            if ($room->room_status_id != 2 && $room->receptionActive[0]->client_id != $client->id) {
                throw new \Exception('La Habitación está ocupada');
            }

            $partial_rate = $room->partialCost->partialRate;
            $partial_rate->append('number_hour');
            Log::info('as1');

            $room_service = (new RoomService($room));
            Log::info('a2');
            $rate = $room_service->getRateByConditionals();
            Log::info('as3');
            $partialCost_new = $room_service->getPartialByConditionals();
            $partial_rate_new = \App\Models\PartialCost::find($partialCost_new)->partialRate->name;

            $quantity_total_hours = $request->quantity_partial * $partial_rate->number_hour;

            $request->merge([
                'date_out' => Carbon::parse($request->date_in)->addHours($quantity_total_hours),
                'partial_min' => $partial_rate_new,
                'rate' => $rate,
            ]);
            Log::info('as5');

            $reception = self::verifiedReceptionActive($client);
            if ($reception) {
                Log::info('v1');

                return self::extendReception($reception, $request, $quantity_total_hours);
            }

            Log::info('z1');

            $reception = $client->receptions()->create($request->only([
                'room_id',
                'date_in',
                'date_out',
                'observation'
            ]));
            if (count($request->companions) > 0) {
                self::storeCompanions($reception, $request->companions);
            }
            Log::info('z2');

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
                $detail->ticket->delete();
                $detail->delete();
            });
            $invoice = $client->invoiceNoPrint;
            $invoice->details->map(function ($detail) {
                $detail->delete();
            });

            $reception->companions->map(function ($companion) {
                $companion->delete();
            });
            $invoice->delete();
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

        self::storeCompanions($reception, $request->companions);
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
        $pdf = new Mpdf(['mode' => 'utf-8', 'format' => [58, 200]]);

        $room = Room::find($request->room_id);

        $rate = (new \App\Services\RoomService\RoomService($room));
        // $room->append('rate_current');
        $room->rate_current = $rate->getRateByConditionals();
        $room->partial_cost_id = $rate->getPartialByConditionals();

        $reception = $room->receptionActive->first();
        $invoice   = $reception->client->invoiceNoPrint;
        $reception_detail = $reception->details()->orderBy('created_at', 'desc')->first();

        $type_payment = '';
        $type_payment2 = '';
        $type_payment3 = '';

        foreach ($invoice->payments as $payment) {
            if ($type_payment == '' && $type_payment2 == '') {
                $type_payment = $payment->type;
                $type_payment2 = $payment->type;
                $type_payment3 = $type_payment;
            }
            $type_payment = $payment->type;
            if ($type_payment != $type_payment2) {
                $type_payment3 = 'mixto';
                break;
            }
            if ($type_payment == $type_payment2) {
                $type_payment2 = $payment->type;
            }
        }
        $notFiscal = new \App\Services\FiscalInvoice\NotFiscalDocumentService();

        $notFiscal->addLineNoFiscal($reception->room->name, 'negrita_centrado');
        $notFiscal->addLineNoFiscal($reception->room->partialCost->roomType->name, 'negrita_centrado');
        $notFiscal->addLineNoFiscal('Cajero:' . Auth::user()->name);
        $notFiscal->addLineNoFiscal('Fecha y Hora de Entrada:' . \Carbon\Carbon::parse($reception->date_in)->format('d-m-Y H:i'));
        $notFiscal->addLineNoFiscal('Fecha y Hora de Salida:' . \Carbon\Carbon::parse($reception->date_out)->format('d-m-Y H:i'));
        $notFiscal->addLineNoFiscal('---------', 'centrado');
        $notFiscal->addLineNoFiscal('Productos', 'negrita_centrado');

        $cont = 1;
        foreach ($invoice->details as $detail) {
            if ($detail->price != 0) {
                $notFiscal->addLineNoFiscal('(' . $cont . ')' . $detail->description);
                $notFiscal->addLineNoFiscal($detail->quantity . ' und *' . $detail->price . '.........' . $detail->quantity * $detail->price);
                $cont++;
            }
        }
        $notFiscal->addLineNoFiscal('---------', 'centrado');
        $notFiscal->addLineNoFiscal('Pagos', 'negrita_centrado');

        foreach ($invoice->payments as $payment) {
            $notFiscal->addLineNoFiscal($payment->type . ' - ' . $payment->method . '.........' . $payment->quantity);
        }
        return $notFiscal->download();

        $html = view('Ticket.Create', [
            'invoice'   => $invoice,
            'reception' => $reception,
            'type_payment' => $type_payment3,
            'total'     => $reception_detail->quantity_partial * $reception_detail->rate
        ]);
        // return $html;
        $pdf->WriteHTML($html);
        $nombre_archivo = 'Ticket';
        header('Content-Type: application/pdf');
        header("Content-Disposition: inline; filename='$nombre_archivo.pdf'");
        return $pdf->Output("$nombre_archivo.pdf", 'I');
    }

    public function transferRoom(TransferRoomRequest $request)
    {
        DB::beginTransaction();
        try {
            Log::info($request->all());
            $transfer = TransferRoom::create($request->all());
            $roomStatus_origin = RoomStatus::firstWhere('name', 'Sucia');

            if ($request->motive == 'Reparación') {
                $roomStatus_origin = RoomStatus::firstWhere('name', 'Fuera de Servicio');
                Repair::create([
                    'room_id'       => $request->room_origin,
                    'report_user'   => Auth::user()->id,
                    'description'   => $request->observation,
                    'report_date'   => Carbon::now(),
                ]);
            }
            $room_origin = Room::find($request->room_origin);

            $reception_origin = $room_origin->receptionActive->first();
            // if($reception_origin->details->count() > 1){
            //     throw new \Exception('Esta habitación ya tiene varias recepciones, debe cancelar o facturar y abrir una nueva');
            // }

            $request['quantity_partial'] = $reception_origin->details[$reception_origin->details->count() - 1]->quantity_partial;
            $request['date_in'] = $reception_origin->date_in;
            $room_destiny = Room::find($request->room_destiny);
            $partial_rate = $room_destiny->partialCost->partialRate;

            $partial_rate->append('number_hour');

            $room_service = (new RoomService($room_destiny));
            $rate = $room_service->getRateByConditionals();
            $partialCost_new = $room_service->getPartialByConditionals();
            $partial_rate_new = \App\Models\PartialCost::find($partialCost_new)->partialRate->name;

            $quantity_total_hours = $request->quantity_partial * $partial_rate->number_hour;

            $new_info = [
                'room_id' => $room_destiny->id,
                'date_out' => Carbon::parse($request->date_in)->addHours($quantity_total_hours),

            ];

            $reception = $room_origin->receptionActive->first();
            $reception->update($new_info);
            $reception_detail = $reception->details->first();
            $reception_detail->update([
                'partial_min' => $partial_rate_new,
                'rate' => $rate
            ]);

            $reception_detail->ticket()->create([
                'observation' => $request->observation
            ]);
            $roomStatus = RoomStatus::firstWhere('name', 'Ocupada');

            $room_origin->update([
                'room_status_id' => $roomStatus_origin->id,
            ]);

            $room_destiny->update([
                'room_status_id' => $roomStatus->id,
            ]);
            DB::commit();
            return;
        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e, __('errors.server.title'), 500);
        }
    }

    private function storeCompanions(Reception $reception, array $companions)
    {

        foreach ($companions as $companion) {

            if (!$companion['id']) {
                $reception->companions()->create([
                    'client_id' => $companion['client_id'],
                    'extra_guest_id' => $companion['extra_guest_id'],
                ]);
            }
        }
    }
}
