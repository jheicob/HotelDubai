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
            'partial_template_id' => 'required|exists:partial_templates,id',
            'theme_type_id' => 'required|exists:theme_types,id',
            'description' => 'required|string',
        ];
    }
}
