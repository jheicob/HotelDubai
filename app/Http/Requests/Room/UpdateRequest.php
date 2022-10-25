<?php

namespace App\Http\Requests\Room;

use App\Traits\CustomResponseFormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Room\VerifiedStatusPermissForCamarero;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        return $user->can('room.updated') || $user->can('room.free');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if((Auth::user()->roles->first())->name == 'Camarero'){
            return [
                'room_status_id' => [
                    'required',
                    'exists:room_statuses,id',
                    new VerifiedStatusPermissForCamarero()
               
                ]
            ]
                ;
        }
        return [
            'room_status_id' => 'required|exists:room_statuses,id',
            'partial_cost_id' => 'required|exists:partial_costs,id',
            'description' => 'required|string',
            'name'      => 'required|string'
        ];
    }
}
