<?php

namespace App\Http\Requests\Tarifas\HourTemplate;

use App\Traits\CustomResponseFormRequestTrait;
use Carbon\Carbon;
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
            'hour'         => 'required|regex:/[\d]{2}:[\d]{2}/',
            'hour_end'     => 'required|regex:/[\d]{2}:[\d]{2}/',
            'rate'         => 'required|numeric',
            'start'        => 'before_or_equal:end',
        ];
    }

    public function prepareForValidation()
    {
        $hour_start = explode(':', $this->hour);
        $hour_end = explode(':', $this->hour_end);
        $this->merge([
            'start' => Carbon::now()->setHours($hour_start[0])->setMinutes($hour_start[1]),
            'end'   => Carbon::now()->setHours($hour_end[0])->setMinutes($hour_end[1]),
        ]);
    }
}
