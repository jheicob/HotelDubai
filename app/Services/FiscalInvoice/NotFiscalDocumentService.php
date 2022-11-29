<?php

namespace App\Services\FiscalInvoice;

use Carbon\Carbon;

class NotFiscalDocumentService extends FiscalInvoiceService{

    /**
     * @param string $line Línea a agregar
     * @param string $style
     *  in normal,negrita,centrado,negrita_centrado,negrita_centrado_doble_ancho,expandido
     *
     * @return bool
     */
    public function addLineNoFiscal(string $line, string $style = 'normal',string $type ='insertar'):void
    {
        $command = config('invoice.commands.doc_no_fiscal.insertar');
        if(($type_style_line = self::verifyStyleFont($style)) !== false){
            $string = $command . '|' . $type_style_line.'|'.$line;
            self::addLine($string);
        }

    }

    /**
     * @param string $style
     *  in normal,negrita,centrado,negrita_centrado,negrita_centrado_doble_ancho,expandido
     *
     * @return string|bool
     */
    private function verifyStyleFont(string $style):string
    {
        $avalaible_styles = [
            'normal' => '0',
            'negrita' => '*',
            'centrado' => '!',
            'negrita_centrado' => '¡',
            'negrita_centrado_doble_ancho' => '$',
            'expandido' => '>'
        ];
        if(!array_key_exists($style,$avalaible_styles)) return false;

        return $avalaible_styles[$style];
    }

    /**
     * download file
     *
     * @param string $filename sin extension
     * @return void
     */
    public function download(string $filename = '', float $base_divisa = 0)
    {
        $command = config('invoice.commands.doc_no_fiscal.cerrar');

        if ($filename == '') {
            $filename = Carbon::now()->format('Y_m_d');
        }

        $string = $command . '|0| Fin del Documento NO fiscal';
        self::addLine($string);

        $filename .= '.ia2';
        header('Content-Type: application/plain-text');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=$filename");

        return $this->document;
    }
}
