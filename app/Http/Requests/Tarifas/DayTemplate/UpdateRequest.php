<?php

namespace App\Http\Requests\Tarifas\DayTemplate;

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
            'room_type_id' => 'required|exists:room_types,id',
            'day_week_id' => 'required|exists:day_weeks,id',
            'rate' => 'required|numeric',
        ];
    }
}
