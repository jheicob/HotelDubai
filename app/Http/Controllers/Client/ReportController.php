<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class ReportController extends Controller
{
    public function report(Request $request)
    {
        $pdf = new Mpdf();

        $clients = Client::all();
        $html = view('client.report', ['clients' => $clients]);

        $pdf->WriteHTML($html);
        $nombre_archivo = 'Reporte-Clientes';
        header('Content-Type: application/pdf');
        header("Content-Disposition: inline; filename='$nombre_archivo.pdf'");
        return $pdf->Output("$nombre_archivo.pdf", 'I');
    }
}
