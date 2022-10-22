<?php

namespace App\Services\FiscalInvoice;

use Carbon\Carbon;

class CreditNoteService extends FiscalInvoiceService {

    protected $credit_note = true;

    public function setHeadForCreditNote(string $client, string $rif, int $invoice_id, string $serial, bool $type): void
    {
        $now = Carbon::now();
        $date = $now->format('d-m-Y');
        $hour = $now->format('H:i');
        // self::includeFistLineForCreditNote();
        // 69|00|NOMBRE / RAZON SOCIAL
        self::includeFirstLineDataCompany();

        if(!$type){
            self::addLineToHead($client);
            self::addLineToHead('RIF: '.$rif);
            self::addLineToHead('FACTURA ORIGINAL: '.$invoice_id);
            self::addLineToHead("FECHA: $date HORA: $hour");
            self::addLineToHead('TICKET N°: NC-'.$invoice_id);
        }else{
            self::setClient($client);
            self::setRif($rif);
            self::setInvoice($invoice_id);
            self::setDate($date);
            self::setMachine($serial);
        }
    }

    /**
     * add first line for a invoice of type credit note
     *
     * @param string $client name of client
     * @param string $rif
     * @param integer $invoice_id
     * @param string $serial_fiscal_machine
     * @return void
     */
    public function includeFistLineForCreditNote(string $client,string $rif,int $invoice_id,string $serial_fiscal_machine):void
    {
        $now = Carbon::now();
        $data = [
            config('invoice.commands.credit_note.init'),
            $client,
            $rif,
            $invoice_id,
            $serial_fiscal_machine,
            $now->format('d/m/Y'),
            $now->format('H:i')
        ];

        $string = self::formatString($data);
        self::addLine($string);
    }

    /**
     * close credit note
     *
     * @param integer $invoice_id
     * @return void
     */
    public function closeCreditNote(int $invoice_id): void
    {
        $data = [
            config('invoice.commands.credit_note.close'),
            $invoice_id
        ];

        $string = self::formatString($data);
        self::addLine($string);
    }

    /**
     * set line of head with name of client
     *
     * @param string $name
     * @return void
     */
    private function setClient(string $name): void
    {
        $data = [
            config('invoice.commands.credit_note.client'),
            $name
        ];
        $string = self::formatString($data);
        self::addLine($string);
    }

    /**
     * set line of head with rif of client
     *
     * @param string $rif
     * @return void
     */
    private function setRif(string $rif): void
    {
        $data = [
            config('invoice.commands.credit_note.rif'),
            $rif
        ];
        $string = self::formatString($data);
        self::addLine($string);
    }

    /**
     * set line of head with invoice id of client
     *
     * @param integer $invoice_id
     * @return void
     */
    private function setInvoice(int $invoice_id): void
    {
        $data = [
            config('invoice.commands.credit_note.invoice_rel'),
            $invoice_id
        ];
        $string = self::formatString($data);
        self::addLine($string);
    }

    /**
     * set line of head with date of client invoice
     *
     * @param string $date
     * @return void
     */
    private function setDate(string $date): void
    {
        $data = [
            config('invoice.commands.credit_note.date_invoice'),
            $date
        ];
        $string = self::formatString($data);
        self::addLine($string);
    }

    /**
     * set line of head with serial fiscal machine of client invoice
     *
     * @param string $serial
     * @return void
     */
    private function setMachine(string $serial): void
    {
        $data = [
            config('invoice.commands.credit_note.serial_machine'),
            $serial
        ];
        $string = self::formatString($data);
        self::addLine($string);
    }

}
