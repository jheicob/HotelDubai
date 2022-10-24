<?php

namespace App\Rules\Invoice;

use App\Models\Client;
use Illuminate\Contracts\Validation\Rule;

class VerifiedTotalPayment implements Rule
{
    protected $reception;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($client_id)
    {
        $this->reception = Client::find($client_id)->receptionActive->first();
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

        foreach ($this->reception->details as $detail) {
            $acum += ($detail->rate * $detail->quantity_partial);
        }

        if ($acum != $value) return false;

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Los pagos son menores al monto total de la factura';
    }
}
