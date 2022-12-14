<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Rules\Client\VerifiedRoleForCancelUseRoom;
use App\Traits\CustomResponseFormRequestTrait;
use Illuminate\Support\Facades\Log;

class CancelUseRequest extends FormRequest
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
            'user_id' => new VerifiedRoleForCancelUseRoom($this->client,$this->room_id)
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'user_id' => Auth::user()->id,
        ]);
    }
}
