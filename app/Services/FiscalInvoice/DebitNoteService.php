<?php

namespace App\Services\FiscalInvoice;

class DebitNoteService extends FiscalInvoiceService
{


    /**
     * add as first line the data of company
     * @return void
     */
    public function includeFirstLineDataCompany($client, $rif): void
    {
        $data = [
            // config('invoice.company'),
            // config('invoice.rif')
            $client,
            $rif
        ];

        $string = implode('|', $data);
        self::addLineToHead($string, 'VE');
    }
}
