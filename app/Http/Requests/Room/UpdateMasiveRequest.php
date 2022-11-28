<?php

namespace App\Http\Requests\Room;

use App\Traits\CustomResponseFormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMasiveRequest extends FormRequest
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
            'room_type_id'     => 'nullable|integer|exists:room_types,id|required_without:room_id',
            'room_id'          => 'nullable|array|required_without:room_type_id',
            'room_id.*'        => 'integer|exists:rooms,id',
            'partial_cost_id'  => 'required|integer|exists:partial_costs,id',
        ];
    }
}
