<?php

namespace App\Rules\Invoice;

use App\Models\Client;
use App\Models\Reception;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;

class VerifiedTotalPayment implements Rule
{
    protected $reception;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($client_id,$room_id)
    {
        Log::warning($client_id);
        Log::warning($room_id);

        $this->reception = Reception::where([
            ['client_id',$client_id],
            ['room_id',$room_id]
        ])->first();

        Log::info($this->reception);
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

        if ($acum > $value) return false;

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
