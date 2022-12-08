<?php

namespace App\Http\Controllers\Invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\UpdateRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Builder;
use Mpdf\Mpdf;

class UpdateController extends Controller
{

    public function updated(UpdateRequest $request, Invoice $invoice)
    {
        try {
            DB::beginTransaction();

            $invoice->update($request->all());

            DB::commit();

            return custom_response_sucessfull('updated successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

    public function report(Request $request){

        if(!$request->has('date_start')){
            $date_start = Invoice::whereHas('details',function(Builder $query){
                $query->where('productable_type','like','%Product');
            })->min('date');
        }else{
            $date_start = $request->input('date_start');
        }

        if(!$request->has('date_end')){
            $date_end = Invoice::whereHas('details',function(Builder $query){
                $query->where('productable_type','like','%Product');
            })->max('date');
        }else{
            $date_end = $request->input('date_end');
        }
        // dd($date_end);
        $invoices = Invoice::whereHas('details',function(Builder $query){
            $query->where('productable_type','like','%Product');
        })
        ->when(($request->date_start && $request->date_end),function(Builder $query) use ($request){
            $query->whereBetween(DB::raw('date_format(date, "%d-%m-%Y")'),[$request->date_start && $request->date_end]);
        })
        ->orderBy('created_at', 'desc')
        ->with([
            'payments',
            'details',
            'client',
            'fiscalMachine.estateType'
        ])
        ->get();

        $pdf = new Mpdf([
            'orientation' => 'L',
            'tempDir'=>storage_path('tempdir')
        ]);

        // return $invoices;
        $html = view('Invoice.PuntoVentaReport', [
            'invoices' => $invoices,
            'date_start' => $date_start,
            'date_end' => $date_end,
            'title_report' => 'Reporte del Punto de Venta'

        ]);
        // return $html;
        $pdf->WriteHTML($html);
        $nombre_archivo = 'Reporte-Habitaciones';
        header('Content-Type: application/pdf');
        header("Content-Disposition: inline; filename='$nombre_archivo.pdf'");
        return $pdf->Output("$nombre_archivo.pdf", 'I');
    }

}
