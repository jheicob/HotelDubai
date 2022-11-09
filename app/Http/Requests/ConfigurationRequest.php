<?php

namespace App\Http\Requests;

use App\Traits\CustomResponseFormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class ConfigurationRequest extends FormRequest
{
    use CustomResponseFormRequestTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "env"                   => "required|string",
            "fiscal_machine_serial" => "required|string",
            "exchange_rate"         => 'required|numeric',
            "warning_time"          => "required|regex:/[\d]{2}:[\d]{2}:[\d]{2}/",
            "cancel_time"           => "required|regex:/[\d]{2}:[\d]{2}:[\d]{2}/"
        ];
    }
}
