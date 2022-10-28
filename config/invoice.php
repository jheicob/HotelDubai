<?php

// Configuraciones para la facturación fiscal

const TYPE_PAGE = [
    'carta'      => 9,
    'semi-carta' => 5
];

return [
    'local' => env('ENV_MAQ','CA-'),

    // Nombre de la compañía que se mostrará en la factura
    'company' => 'Hotel Dubai',

    'rif'     => '123456',

    // configuraciones para los comentarios
    'comments' => [

        // caracteres maximos permitidos por linea
        'char_max' => 39,

        // tipo de hoja
        // carta, semi-carta
        'type_page' => 'carta',

        // lineas maximas
        'lines_max' => TYPE_PAGE['carta']
    ],

    // comandos necesarios para el funcionamiento correcto de la factura fiscal
    'commands' => [

        // datos del cliente o adicionales que se muestran antes del producto
        'head' => 69,

        // comentario de la factura
        'comment' => 40,

        'products' => [
            'include' => '64|PV*',
            //excento de iva
            'excent' => 20,

            // iva general
            'general' => 21,

            // iva reducido
            'reduc' => 22,

            // iva agregado
            'add' => 23
        ],

        // corrige el ultimo producto o descuento agregado
        'correct' => '6B|k',

        // imprimir subtotal, necesario para aplicar descuento
        'sub_total' => 33,

        'additional' => [

            // por monto
            'amount' => 70,

            // por porcentaje
            'percentage' => 71
        ],

        // totalizar factura fiscal
        'total' => 31,

        'printer' => 'FF',

        'printer_invoice' => '99|20',

        'credit_note' => [
            'init' => 'XX',
            'close' => 'FE',
            'client' => '69|S*',
            'rif'    => '69|R*',
            'invoice_rel' => '69|F*',
            'date_invoice' => '69|D*',
            'serial_machine' => '69|I*',
            'product'     => 64,
        ],

        'payment_methods' => [
            'credit_card' => '13',
            'debit_card'  => '10',
            'cash'        => '01',
            'cheque'      => '08'
        ]
    ]
];
