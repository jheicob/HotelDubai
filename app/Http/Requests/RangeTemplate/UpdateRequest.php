<?php

namespace App\Http\Requests\RangeTemplate;

use App\Traits\CustomResponseFormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'room_type_id' => "required|exists:room_types,id",
            'partial_rate_id' => "required|exists:partial_rates,id",
            'date_start' => "required|date_format:Y-m-d|before:date_end",
            'date_end' => "required|date_format:Y-m-d",
            'rate' => "nullable|",
        ];
    }
}
