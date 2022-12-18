<?php

namespace App\Rules;

use App\Models\Reception;
use App\Models\Room;
use App\Services\RoomService\RoomService;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class VerifyReservation implements Rule
{
    protected $date;
    protected $quantity_partial;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($date, $quantity_partial)
    {
        $this->date = $date;
        $this->quantity_partial = $quantity_partial;
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
        $reception = Reception::where([
            ['room_id',$value],
            ['reservation',1],
            ['date_in','<=',$this->date],
            ['date_out','>=',$this->date]
        ])->first();

        if($reception) return false;

        $room = Room::find($value);
        $partial_rate = $room->partialCost->partialRate;
        $partial_rate->append('number_hour');

        $quantity_total_hours = $this->quantity_partial * $partial_rate->number_hour;

        $date_out = Carbon::parse($this->date)->addHours($quantity_total_hours);
        $reception = Reception::where([
            ['room_id',$value],
            ['reservation',1],
            ['date_in','<=',$date_out],
            ['date_out','>=',$date_out]
        ])->first();

        if($reception) return false;

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'La habitación tiene una reserva para esa fecha.';
    }
}
