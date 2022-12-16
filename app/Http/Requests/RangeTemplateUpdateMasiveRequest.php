<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RangeTemplateUpdateMasiveRequest extends FormRequest
{
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
            'day_template_id' => 'required|array',
            'day_template_id.*'      => 'exists:range_templates,id',
            'rate' => 'required|numeric'
        ];
    }
}
