<?php

namespace App\Rules;

use App\Models\DayTemplate;
use Illuminate\Contracts\Validation\Rule;

class ValidateRangeHourRule implements Rule
{
    protected $days_weeks;
    protected $hour_start;
    protected $hour_end;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($days_weeks,$hour_start,$hour_end)
    {
        $this->days_weeks = $days_weeks;
        $this->hour_start = $hour_start;
        $this->hour_end = $hour_end;
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
        foreach($value as $room_type){
            foreach($this->days_weeks as $day_week){
                if(!self::verifyHoursRange($room_type,$day_week)){
                    return false;
                };
            }
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
        return 'Ya Existe una plantilla dentro de ese rango de horas.';
    }

    private function verifyHoursRange(int $room_type_id,int $day_week_id):bool
    {
        $date_templates = DayTemplate::where([
                        ['room_type_id' , $room_type_id],
                        ['day_week_id'  , $day_week_id],
                        // ['hour_start'   , $start],
                        // ['hour_end'     , $end],
                    ])->get();

        $bool = true;
        foreach($date_templates as $date_template){

            $item_start = \Carbon\Carbon::now()->setHour($date_template->hour_start);
            $item_end = \Carbon\Carbon::now()->setHour($date_template->hour_end);

            $new_start = \Carbon\Carbon::now()->setHour($this->hour_start);
            $new_end = \Carbon\Carbon::now()->setHour($this->hour_end);

            if(
                ($item_start>= $new_start && $item_start <= $new_end) ||
                ($item_end>= $new_start && $item_end <= $new_end)
            ){
                $bool = false;
            }
        }



        return $bool;
    }

}
