<?php

namespace App\Http\Requests\Client;

use App\Rules\Client\VerifiedReceptionAndRoom;
use App\Rules\VerifyReservation;
use App\Traits\CustomResponseFormRequestTrait;
use Carbon\Carbon;
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
            'room_id' => ['required','exists:rooms,id', new VerifyReservation($this->date_in,$this->quantity_partial)],
            'client_id' => [
                'required',
                'exists:clients,id',
                // new VerifiedReceptionAndRoom($this->room_id)
            ],
            'date_in' => 'required|date_format:Y-m-d H:i|after_or_equal:'. Carbon::now()->format('Y-m-d H:i'),
            'observation' => 'nullable|string',
            'quantity_partial' => 'required|numeric',
        ];
    }
}
