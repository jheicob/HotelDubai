<?php

namespace App\Http\Requests\Invoice;

use App\Rules\Invoice\VerifiedReceptionDetailOfClient;
use App\Traits\CustomResponseFormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'client_id'     => 'required|exists:clients,id',
            // 'reception_details'  => 'required|array',
            // 'reception_details.*.id'   => [
            //     'nullable',
            //     'integer',
            //     'exists:reception_details,id',
            //     new VerifiedReceptionDetailOfClient($this->client_id)
            // ],
            // 'reception_details.*.time_additional'   => 'nullable|string',
            // 'reception_details.*.price_additional'  => 'nullable|numeric',
            // 'products'  => 'required|array',
            // 'products.*.id'   => 'nullable|string',
            // 'products.*.time_additional'   => 'nullable|string',
            // 'products.*.price_additional'  => 'nullable|numeric',
        ];
    }
}
