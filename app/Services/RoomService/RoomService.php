<?php

namespace App\Services\RoomService;

use App\Models\ClientRoom;
use App\Models\DateTemplate;
use App\Models\DayTemplate;
use App\Models\HourTemplate;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class RoomService {

    protected $room;

    protected $acum;

    protected $renew;
    protected $now;
    protected $date;
    protected $room_type_id;
    protected $dayName;
    public function __construct(Room $room,bool $renew = false)
    {
        $this->room = $room;
        $this->renew = $renew;
        $this->room_type_id = $this->room->partialCost->room_type_id;
        self::setVars();
    }

    private function setVars(){

        if($this->renew){
            $this->room->load('roomActive');
            $detail = ClientRoom::where('room_id',$this->room->id)
                        ->where('client_id',$this->room->roomActive[0]->id)
                        ->where('invoiced',false)
                        ->orderBy('date_out','desc')
                        ->first()
                        ;
            $this->now = Carbon::parse($detail->date_out);
        }else{
            $this->now = Carbon::now();
        }
        $this->acum = $this->room->partialCost->rate;
        $this->dayName = $this->now->locale('es')->dayName;
        $this->date = $this->now->format('m/d');

    }


    public function getRateByConditionals(){


        $this->acum += self::getRateByDate($this->date);
        $this->acum += self::getRateByDay($this->dayName);
        $this->acum += self::getRateByHour();

        return $this->acum;
    }

    private function getRateByDay($dayNameCurrent): int
    {
        // falta mostrar todo lo que se esta aplicando para mostrarlo en el detalle de ñla habitacion
        // falta tambien agregar rango de horas para las fechas

        $day_template = DayTemplate::whereHas('dayWeek',function(Builder $builder) use ($dayNameCurrent){
            return $builder->where(
                                DB::raw('lower(name)'),
                                'like',
                                DB::raw("lower('$dayNameCurrent')")
                            );
                    })
                    ->where('room_type_id',$this->room_type_id)
                    ->first()
                    ;

        if($day_template != ''){
            return (int) $day_template->rate;
        }
        return 0;
    }

    /**
     * get rate by date
     *
     * @param string $dateCurrent format dd/mm
     * @return integer
     */
    private function getRateByDate($dateCurrent): int
    {
        $date_template = DateTemplate::where('date',$dateCurrent)
                    ->where('room_type_id',$this->room_type_id)
                    ->first()
                    ;

        if($date_template != ''){
            return (int) $date_template->rate;
        }
        return 0;
    }

    private function getRateByHour(): int
    {
        $hour_template = HourTemplate::where('room_type_id',$this->room_type_id)
                    ->get()
                    ;

        if($hour_template->count() == 0){
            return 0;
        }

        $now = Carbon::now();
        $bool = $hour_template->map(function($hour) use ($now){
            $start = self::setHourByString($hour->hour);
            $end = self::setHourByString($hour->hour_end);
            if($now >= $start && $now <= $end){
                return $hour;
            }
        })->filter()->first();
        if($bool != ''){
            return (int) $bool->rate;
        }
        return 0;
    }

    private function setHourByString(string $hour_start): Carbon
    {
        $hour = explode(':',$hour_start);
        $now = Carbon::now();
        $now->hour   = $hour[0];
        $now->minute = $hour[1];

        return $now;
    }
}
