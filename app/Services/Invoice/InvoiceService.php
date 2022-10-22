<?php

namespace App\Services\Invoice;

use App\Models\Invoice;
use App\Models\Reception;
use App\Services\FiscalInvoice\CreditNoteService;
use App\Services\FiscalInvoice\DebitNoteService;

class InvoiceService {

    /**
     * @var Invoice $invoice
     */
    protected $invoice;

    /**
     * @var CreditNoteService
     */
    protected $credit_note;

    /**
     * @var DebitNoteService
     */
    protected $debit_note;

    public function __construct(Invoice $invoice, CreditNoteService $credit_note, DebitNoteService $debit_note)
    {
        $this->invoice = $invoice;
        $this->fiscal_invoice = $credit_note;
        $this->debit_note = $debit_note;
    }

    public function calculateTotalByReceptionDetails(Reception $reception){
        $details = $reception->details;

        $total = 0;
        foreach($details as $detail){
            $total += $detail->rate * $detail->quantity_partial;
        }

        return $total;
    }

    public function generateFiscalInvoice()
    {

    }

}
