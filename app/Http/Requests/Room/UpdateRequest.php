<?php

namespace App\Http\Requests\Room;

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
            'room_status_id' => 'required|exists:room_statuses,id',
            'partial_cost_id' => 'required|exists:partial_costs,id',
            'description' => 'required|string',
            'name'      => 'required|string'
        ];
    }
}
