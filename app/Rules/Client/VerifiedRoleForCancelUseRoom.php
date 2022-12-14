<?php

namespace App\Rules\Client;

use App\Models\Reception;
use App\Traits\Configurations\GeneralConfiguration;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VerifiedRoleForCancelUseRoom implements Rule
{
    use GeneralConfiguration;

    protected $client;
    protected $room_id;
    protected $reception;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($client, $room_id)
    {
        $this->client = $client;
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
        $this->reception = Reception::where([
            ['room_id',$this->room_id],
            ['client_id', $this->client->id]
        ])->first();

        if ($this->reception == '') return false;

        $rol = Auth::user()->roles->first();

        switch ($rol->name) {
            case 'Admin':
                return true;
            case 'Recepcionista':
                return self::verifiedTimeOut();
            case 'Supervisor':
                return true;
            default:
                return false;
        }
    }

    public function verifiedTimeOut()
    {
        $conf = $this->getGeneralConfiguration();
        $times = explode(':', $conf->cancel_time);

        $time_start = Carbon::parse($this->reception->date_in)
            ->addHours($times[0])
            ->addMinutes($times[1])
            ->addSeconds($times[2]);
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
