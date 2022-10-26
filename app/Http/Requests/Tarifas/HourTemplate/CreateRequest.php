<?php

namespace App\Http\Requests\Tarifas\HourTemplate;

use App\Traits\CustomResponseFormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'room_type_id' => 'required|exists:room_types,id',
            'hour'         => 'required|regex:/[\d]{2}:[\d]{2}/',
            'hour_end'     => 'required|regex:/[\d]{2}:[\d]{2}/',
            'rate'         => 'required|numeric',
        ];
    }
}
