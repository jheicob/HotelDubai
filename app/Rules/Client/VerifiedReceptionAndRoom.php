<?php

namespace App\Rules\Client;

use App\Models\Client;
use Illuminate\Contracts\Validation\Rule;

class VerifiedReceptionAndRoom implements Rule
{
    protected $room_id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $room_id)
    {
        $this->room_id = $room_id;
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
        return true; // un cliente puede tener muchas habitaciones asignadas
        $client = Client::find($value);

        $reception = $client->receptionActive->first();

        if ($reception == '') return true;
        if ($reception->room_id == $this->room_id) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El cliente ya tiene una habitación asignada.';
    }
}
