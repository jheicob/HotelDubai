<?php

namespace App\Rules\Invoice;

use App\Models\Client;
use Illuminate\Contracts\Validation\Rule;

class VerifiedReceptionDetailOfClient implements Rule
{
    protected $client;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $client_id)
    {
        $this->client = Client::find($client_id);
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
        $detail = $this->client->receptionActive[0]->details->where('id', $value)->first();

        if(!$detail){
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
        return 'El id del detalle no pertenece a la recepción del cliente';
    }
}
