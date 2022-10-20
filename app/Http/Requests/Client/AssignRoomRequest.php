<?php

namespace App\Http\Requests\Client;

use App\Rules\Client\VerifiedReceptionAndRoom;
use App\Traits\CustomResponseFormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class AssignRoomRequest extends FormRequest
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
            'client_id' => [
                'required',
                'exists:clients,id',
                new VerifiedReceptionAndRoom($this->room_id)
            ],
            'room_id' => 'required|exists:rooms,id',
            'date_in' => 'required|date',
            'observation' => 'nullable|string',
            'quantity_partial' => 'required|numeric',
        ];
    }

}
