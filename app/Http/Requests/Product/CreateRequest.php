<?php

namespace App\Http\Requests\Product;

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
            'name' => 'required|string',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'description' => 'required|string',
            'visible'   => 'required|bool',
            'inventory' => 'required',
            'inventory.stock' => 'required|integer',
            'inventory.stock_min' => 'required|integer'
        ];
    }
}
