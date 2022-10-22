<?php

namespace App\Services\FiscalInvoice;

use Carbon\Carbon;

class FiscalInvoiceService
{


    /**
     * contador de lineas de comentarios;
     * @var int
     */
    protected $cont_lines_comment = 0;

    /**
     * string para formar el documento fiscal
     * @var string
     */
    protected $document = '';

    /**
     * Command for get discounts of invoice
     *
     * @var array
     */
    protected $discount;

    /**
     * UCommand for get iva of product
     *
     * @var array
     */
    public $ivaProduct;

    /**
     * Commands for get payment methods
     */
    protected $payment_methods;

    /**
     * is a credit note
     *
     * @var boolean
     */
    protected $credit_note = false;

    protected $client;
    protected $rif;
    public function __construct()
    {
        $this->cont_lines_comment = 0;


        // self::includeFirstLineDataCompany();
        $this->discount = config('invoice.commands.additional');
        $this->ivaProduct = config('invoice.commands.products');
        $this->payment_methods = config('invoice.commands.payment_methods');
    }
    /**
     * get iva
     *
     * @param string $type
     * @return void
     */
    public function getIva(string $type): string
    {
        return (string) $this->ivaProduct[$type];
    }

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

    /**
     * apply subtotal to invoice
     */
    public function applySubTotal(): void
    {
        $string = config('invoice.commands.sub_total');
        self::addLine($string);
    }

    /**
     * validate the count of lines max by type page
     * @return void
     */
    protected function validateLinesMax(): void
    {
        $max = config('invoice.comments.lines_max');

        if (self::getCountLines() > $max) {
            throw new \Exception('Límite máximo de líneas para los comentarios excedido');
        }
    }

    /**
     * Add Line to document
     *
     * @param string $line
     * @return void
     */
    protected function addLine(string $line): void
    {
        $this->document .= $line;
        self::addLineBreak();
    }

    /**
     * Add line break to final line
     *
     * @return void
     */
    protected function addLineBreak(): void
    {
        $this->document .= '\n';
    }

    /**
     * Get var cont_lines_comment
     *
     * @return integer
     */
    protected function getCountLines(): int
    {
        return $this->cont_lines_comment;
    }

    /**
     * add 1 to var cont_lines_comment
     *
     * @return void
     */
    protected function addLineToCountLines(): void
    {
        $this->cont_lines_comment++;
    }

    /**
     * pad with zeros the number input
     *
     * @param mixed $number
     * @param integer $quantity_spaces
     * @return string
     */
    protected function padWithZeros(mixed $number, int $quantity_spaces, int $quantity_decimal): string
    {
        $string = number_format($number, $quantity_decimal, '.', '');

        $length_number = strlen($string);
        if ($length_number > $quantity_spaces) return $string;

        $spaces_to_pad = $quantity_spaces - $length_number;
        $number_pad_with_zeros = str_pad($string, $spaces_to_pad, "0", STR_PAD_LEFT);

        return $number_pad_with_zeros;
    }

    /**
     * Format string with |
     * @var array $data one dimension
     * @return string
     */
    protected function formatString(array $data): string
    {
        return implode('|', $data);
    }

    // ---------------

    /**
     * Add comment to invoice
     * @param string $comment comment to add
     */
    public function addComment(string $comment): void
    {
        $command = config('invoice.commands.comment');
        $string = $command . '|' . $comment;
        self::addLine($string);
    }

    /**
     * Add line to head in fiscal invoice
     *
     * @param string $text
     * @return void
     */
    public function addLineToHead(string $text, string $first = ''): void
    {
        if (strlen($text) > 39) {
            throw new \Exception('Máximo de carácteres excedidos para la línea');
        }
        self::validateLinesMax();

        $data = [
            config('invoice.commands.head'),
            $first != '' ? $first : '0' . self::getCountLines(),
            $text
        ];

        $string = self::formatString($data);
        self::addLine($string);
        self::addLineToCountLines();
    }

    public function addPaymentMethod(string $payment_method): void
    {
        if (!array_key_exists($payment_method, $this->payment_methods)) {
            throw new \Exception('Tipo de pago no disponible');
        }

        $data = [
            config('invoice.command.total'),
            $payment_method
        ];

        $string = self::formatString($data);
        self::addLine($string);
    }

    public function addProduct(int $price, int $quantity, string $description, string $iva): void
    {
        if (!array_key_exists($iva, $this->ivaProduct)) {
            throw new \Exception('Impuesto no disponible');
        }
        $getIva = self::getIva($iva);

        $data = [
            self::padWithZeros($price, 10, 2),
            self::padWithZeros($quantity, 8, 3),
            $description,
        ];

        if ($this->credit_note) {
            array_unshift(
                $data,
                config('invoice.commands.credit_note.product'),
                $getIva[1]
            );
        } else {
            array_unshift(
                $data,
                $getIva
            );
        }
        $string = self::formatString($data);
        self::addLine($string);
    }

    public function applyTotal()
    {
        self::addLine(config('invoice.commands.printer_invoice'));
    }

    /**
     * download file
     *
     * @param string $filename sin extension
     * @return void
     */
    public function download(string $filename = '', bool $igtf)
    {
        if ($filename == '') {
            $filename = Carbon::now()->format('Y_m_d') . '-factura_fiscal';
        }

        $filename .= '.ia2';

        if (!$igtf) {
            self::addLine(config('invoice.commands.printer_invoice'));
        } else {
            self::addLine(config('invoice.commands.printer_invoice_igtf'));
        }
        header('Content-Type: application/plain-text');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=$filename");

        return $this->document;
    }
}
