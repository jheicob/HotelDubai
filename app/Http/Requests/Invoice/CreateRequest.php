<?php

namespace App\Http\Requests\Invoice;

use App\Rules\Invoice\VerifiedReceptionDetailOfClient;
use App\Rules\Invoice\VerifiedTotalPayment;
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
            'payments' => 'required|array',
            'payments.*.type'        => 'required|in:divisa,Bs',
            'payments.*.method'      => 'required|in:efectivo,digital,tarjeta',
            'payments.*.quantity'    => 'required|numeric',
            'payments.*.description' => 'required|string',
            'total_payment' => new VerifiedTotalPayment($this->client_id)
        ];
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
