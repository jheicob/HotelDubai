<?php

namespace App\Services\FiscalInvoice;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
     * limit max for first line
     * @var int
     */
    protected $limitLineHead = 39;

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

    protected $factura_fiscal = 'factura_fiscal';
    protected $client;
    protected $invoice_id;
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
    /*    public function includeFirstLineDataCompany($client, $rif): void
    {
        $data = [
            // config('invoice.company'),
            // config('invoice.rif')
            $client,
            $rif
        ];

        $string = implode('|', $data);
        self::addLineToHead($string, 'VE');
    }*/

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
        $this->document .= "\n";
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
     * @param int $number
     * @param integer $quantity_spaces
     * @return string
     */
    protected function padWithZeros(float $number, int $quantity_spaces, int $quantity_decimal): string
    {
        Log::info('precio_llegado:'.$number);
        Log::info('espacios:'.$quantity_spaces);
        Log::info('decimales:'.$quantity_decimal);
        $string = number_format($number, $quantity_decimal, '.', '');
        Log::info('format_number:'.$string);
        $length_number = strlen($string);
        if ($length_number > $quantity_spaces) {
            return $string;
        }

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
        if (strlen($text) > $this->limitLineHead) {
            throw new \Exception('Máximo de carácteres excedidos para la línea:' . $text);
        }
        self::validateLinesMax();

        $data = [
            config('invoice.commands.head'),
            $first != '' ? $first : '0' . self::getCountLines(),
            $text
        ];

        $string = self::formatString($data);
        self::addLine($string);
        if (!$this->credit_note) {
            self::addLineToCountLines();
        }
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

    public function addProduct(float $price, int $quantity, string $description, int $iva = 0): void
    {

        $data = [
            config('invoice.commands.products.include'),
            self::padWithZeros($price, 10, 2),
            self::padWithZeros($quantity, 8, 3),
            self::padWithZeros($iva, 4, 2),
            $description,
        ];
        $string = self::formatString($data);
        self::addLine($string);
    }

    public function applyTotal()
    {
        self::addLine(config('invoice.commands.printer_invoice'));
    }

    public function setInvoiceId(int $invoice_id)
    {
        $this->invoice_id = $invoice_id;
    }
    /**
     * download file
     *
     * @param string $filename sin extension
     * @return void
     */
    public function download(string $filename = '', int $base_divisa = 0)
    {
        if ($filename == '') {
            $filename = Carbon::now()->format('Y_m_d') . '-' . $this->factura_fiscal;
        }

        $filename .= '.ia2';
        $line = config('invoice.commands.printer_invoice') . '|';
        $number_format = number_format($base_divisa, 2);
        $number_format = str_replace(',', '', $number_format);
        $line .= $number_format;
        self::addLine($line);

        $line = config('invoice.commands.printer') . '|';
        $line .= $this->invoice_id;
        self::addLine($line);

        header('Content-Type: application/plain-text');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=$filename");

        return $this->document;
    }


    /**
     * add discount to invoice, not need apply the applySubTotal method before
     *
     * @param string $type 'percentage' or 'amount'
     * @param boolean $is_plus true = sum, false = subs
     * @param integer $amount
     * @return void
     */
    public function addDiscountToSubTotal(string $type, bool $is_plus, int $amount): void
    {
        self::applySubTotal();
        if (!array_key_exists($type, $this->discount)) {
            throw new \Exception('Tipo de descuento no disponible');
        }

        $quantity_int = $this->discount[$type] == 70 ?
            2 : 7;
        $data = [
            $this->discount[$type],
            $is_plus ? '+' : '-',
            self::padWithZeros($amount, $quantity_int + 2, 2)
        ];

        $string = self::formatString($data);
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
