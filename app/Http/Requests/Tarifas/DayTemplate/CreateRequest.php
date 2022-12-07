<?php

namespace App\Http\Requests\Tarifas\DayTemplate;

use App\Traits\CustomResponseFormRequestTrait;
use Carbon\Carbon;
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
            'room_type_id' => 'required|array',
            'room_type_id.*' => 'exists:room_types,id',
            'day_week_id' => 'required|array',
            'day_week_id.*' => 'exists:day_weeks,id',
            'rate' => 'required|numeric',
            'hour_start' => 'required',
            'hour_end' => 'required',
            'init' => 'before:end'
        ];
    }

    public function prepareForValidation(){
        $start = explode(':',$this->hour_start);
        $end = explode(':',$this->hour_end);
        $this->merge([
            'init' => self::setNewDate($start[0],$start[1]),
            'end' => self::setNewDate($end[0],$end[1]),
        ]);
    }

    private function setNewDate(string $hour,string $minute){
        return Carbon::now()->setHour($hour)->setMinute($minute)->format('Y-m-d H:i');
    }
}
