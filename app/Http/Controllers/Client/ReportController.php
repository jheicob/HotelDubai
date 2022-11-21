<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Reception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
Use Carbon\Carbon;
class ReportController extends Controller
{
    public function report(Request $request)
    {
        $pdf = new Mpdf();
        if(!$request->date_start){
            $request['date_start'] = Reception::min('date_out');
        }
        if(!$request->date_end){
            $request['date_end'] = Reception::max('date_out');
        }
        // dd($request->all());
        $clients = Client::with([
                        'typeDocument',
                        'receptionClosed.room.partialCost.roomType',
                        'receptionClosed.companions.client'
                        ])
                    ->whereHas('receptionClosed',function(Builder $query) use ($request){
                        $query->when($request->date_start && $request->date_out,function(Builder $q) use ($request){
                            $q->whereBetween('created_at', [$request->date_start, $request->date_end]);
                        })
                        ->when($request->room_type_id,function(Builder $query) use ($request){
                                $query->whereHas('room',function(Builder $query) use ($request){
                                    $query->whereHas('partialCost',function(Builder $query) use ($request){
                                        $query->whereIn('room_type_id',$request->room_type_id);
                                });
                            });
                        })
                        ->when($request->client_id,function(Builder $query) use ($request){
                            $query->whereIn('client_id',$request->client_id);
                        })
                        ;

                    })
                    ->get();
        $html = view('client.report', [
            'clients' => $clients,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'count_companions' => 0
        ]);
        $pdf->WriteHTML($html);
        $nombre_archivo = 'Reporte-Clientes';
        header('Content-Type: application/pdf');
        header("Content-Disposition: inline; filename='$nombre_archivo.pdf'");
        return $pdf->Output("$nombre_archivo.pdf", 'I');
    }
}
