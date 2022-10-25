<?php

namespace App\Services\FiscalInvoice;

use Carbon\Carbon;
use App\Models\Invoice;

class CreditNoteService extends FiscalInvoiceService
{
    protected $limitLineHead = 65;
    protected $factura_fiscal = 'devolucion';
    /**
     * add as first line the data of company for credit note
     * @return void
     */
    public function includeFirstLineDataCompanyForCN(string $client, string $full_rif, Invoice $invoice, string $serial_machine): void
    {
        $data = [
            $client,
            $full_rif,
            $invoice->id,
            $serial_machine,
            Carbon::parse($invoice->date)->format('d/m/Y')
        ];

        $string = implode('|', $data);
        self::addLineToHead($string, 'NC');
    }
}
