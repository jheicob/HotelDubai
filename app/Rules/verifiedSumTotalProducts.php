<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class verifiedSumTotalProducts implements Rule
{
    protected $products;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($products)
    {
        $this->products = $products;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $acum = 0;

        foreach($this->products as $product) {
            $acum += $product['price'] * $product['quantity'];
        }

        if($value < $acum){
            return false;
        }
        return true;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El pago es menor al total a pagar .';
    }
}
