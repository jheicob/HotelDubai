<?php

namespace App\Rules\Client;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VerifiedRoleForCancelUseRoom implements Rule
{
    protected $client;
    protected $reception;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($client)
    {
        $this->client = $client;
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
        $this->reception = $this->client->receptionActive->first();

        if ($this->reception == '') return false;

        $rol = Auth::user()->roles->first();

        switch ($rol->name) {
            case 'Admin':
                return true;
            case 'Recepcionista':
                return self::verifiedTimeOut(15);
            case 'Supervisor':
                return true;
            default:
                return false;
        }
    }

    public function verifiedTimeOut(int $minutes)
    {
        $time_start = Carbon::parse($this->reception->date_in)->addMinutes($minutes);
        $now = Carbon::now();
        if ($now->isAfter($time_start)) return false;
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Excedió el tiempo de cancelación de esta habitación.';
    }
}
