<?php

namespace App\Http\Requests\Tarifas\PartialCost;

use Illuminate\Foundation\Http\FormRequest;

class MultiupdateRequest extends FormRequest
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
            'room_types'        => 'required|array',
            'room_types.*'      => 'exists:room_types,id',
            'partial_rates'     => 'required|array',
            'partial_rates.*'   => 'exists:partial_rates,id',
            'rate'              => 'required|numeric'
        ];
    }
}
