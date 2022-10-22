<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceReceptionRequest extends FormRequest
{
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
            'client_id'   => 'required|exists:clients,id',
            'products'    => 'required|array',
            'products.*'  => ''
        ];
    }
}
