<?php

namespace App\Http\Requests\Invoice;

use App\Rules\Invoice\VerifiedTotalPayment;
use App\Rules\verifiedSumTotalProducts;
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
        $data = [
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
            'products'  => 'nullable|array',
            // 'products.*.id'   => 'nullable|exists:products,id',
            'products.*.quantity'   => 'nullable|integer',

            'payments' => 'required|array',
            'payments.*.type'        => 'required|in:divisa,Bs',
            'payments.*.method'      => 'required|in:efectivo,digital,tarjeta',
            'payments.*.quantity'    => 'required|numeric',
            'payments.*.description' => 'nullable|string',

        ];
        if ($this->reception_details && count($this->reception_details) > 0) {
            $data['total_payment'] = new VerifiedTotalPayment($this->client_id,$this->room_id);
        }
        if ($this->products && count($this->products) > 0) {
            $data['total_payment'] = new verifiedSumTotalProducts($this->products);
        }
        return $data;
    }

    public function prepareForValidation()
    {

        $this->merge([
            'total_payment' => self::getTotalPayment()
        ]);
    }

    private function getTotalPayment()
    {
        $acum = 0;
        foreach ($this->payments as $payment) {
            $acum += $payment['quantity'];
        }
        return $acum;
    }
}
