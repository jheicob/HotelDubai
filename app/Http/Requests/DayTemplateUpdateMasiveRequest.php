<?php

namespace App\Http\Requests;

use App\Traits\CustomResponseFormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class DayTemplateUpdateMasiveRequest extends FormRequest
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
            'day_template_id' => 'required|array',
            'day_template_id.*' =>'required|integer|exists:day_templates,id',
            'rate' => 'required|numeric|min:0',
        ];
    }
}
