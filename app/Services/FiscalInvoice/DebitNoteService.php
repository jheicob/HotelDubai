<?php

namespace App\Services\FiscalInvoice;

class DebitNoteService extends FiscalInvoiceService {



    /**
     * add discount to invoice, not need apply the applySubTotal method before
     *
     * @param string $type 'percentage' or 'amount'
     * @param boolean $is_plus true = sum, false = subs
     * @param integer $amount
     * @return void
     */
    public function addDiscountToSubTotal(string $type,bool $is_plus,int $amount): void
    {
        self::applySubTotal();
        if(!array_key_exists($type,$this->discount)){
            throw new \Exception('Tipo de descuento no disponible');
        }

        $quantity_int = $this->discount[$type] == 70 ?
                2 : 7;
        $data = [
            $this->discount[$type],
            $is_plus? '+' : '-',
            self::padWithZeros($amount,$quantity_int+2,2)
        ];

        $string = self::formatString($data);
        self::addLine($string);
    }

    /**
     * apply subtotal to invoice
     */
    private function applySubTotal(): void
    {
        $string = self::formatString(config('invoice.commands.subtotal'));
        self::addLine($string);
    }


    public function getInformationOfPrinter(int $invoice_id): void
    {
        $data = [
            config('invoice.commands.printer'),
            $invoice_id
        ];

        $string = self::formatString($data);
        self::addLine($string);

    }
}
