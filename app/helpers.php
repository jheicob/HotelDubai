<?php

use App\User;
use Illuminate\Support\Facades\Log;

if (!function_exists('custom_response_sucessfull')) {
    function custom_response_sucessfull($message, $code = 200)
    {
        return response()->json(
            [
                "message" => $message
            ],
            $code
        );
    }
}

if (!function_exists('custom_response_exception')) {
    function custom_response_exception(Exception $e, $message, $code = 400)
    {
        Log::info('--------------------------');
        Log::error("Archivo: ". $e->getFile());
        Log::error("Código: ". $e->getCode());
        Log::error("Línea: ". $e->getLine());
        Log::error("error: ". $e->getMessage());
        Log::info('--------------------------');

        $error_message = [
            'error-code' => $e->getCode(),
            'error-message' => $e->getMessage(),
            'error-file' => $e->getFile(),
            'error-line' => $e->getLine(),
        ];

        try{
            if(gettype($e->getMessage()) == 'string'){
                $get_error = $e->getMessage();
                if(
                    $get_error[0] == '[' && $get_error[strlen($get_error)-1] == ']'
                    || $get_error[0] == '{' && $get_error[strlen($get_error)-1] == '}'
                ){
                    $data = json_decode($get_error);
                }else
                {
                    $data = $e->getMessage();
                }
            }else
            if(gettype($e->getMessage()) == 'array'){
                $data = $e->getMessage();
            }
        }catch(\Exception $ex){
            $data = $e->getMessage();
        }
        /**
         * Cambiar $error_message por $data,
         * $error_message solo para ambientes de prueba, muestra con detalle el error
         */
        return custom_response_error($e->getCode(), $message, $data, $code);
    }
}

if (!function_exists('custom_response_error')) {
    function custom_response_error($code_data, $title, $message, $code_response = 400)
    {
        return response()->json(
            [
                'data' => [
                    'code' => $code_data,
                    'title' => $title,
                    'errors' => $message,
                ]
            ],
            $code_response
        );
    }
}

