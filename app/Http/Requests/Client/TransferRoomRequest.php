<?php

namespace App\Http\Requests\Client;

use App\Traits\CustomResponseFormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class TransferRoomRequest extends FormRequest
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
            'room_origin' => 'required|exists:rooms,id',
            'room_destiny' => 'required|exists:rooms,id',
            'motive'        => 'required|in:Reparación,Inconformidad',
            'observation'   => 'required|string',
        ];
    }
}
