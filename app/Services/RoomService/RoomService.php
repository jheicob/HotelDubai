<?php

namespace App\Services\RoomService;

use App\Models\ClientRoom;
use App\Models\DateTemplate;
use App\Models\DayTemplate;
use App\Models\HourTemplate;
use App\Models\RangeTemplate;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class RoomService
{

    protected $room;

    protected $acum;

    protected $renew;
    protected $now;
    protected $date;
    protected $room_type_id;
    protected $dayName;
    protected $partial_min;
    protected $partial_init;
    protected $bool_date = false;

    public function __construct(Room $room, bool $renew = false)
    {
        $this->room = $room;
        $this->renew = $renew;
        $this->room_type_id = $this->room->partialCost->room_type_id;
        $this->partial_min  = $this->partial_init = $this->room->partialCost->id;
        self::setVars();
    }

    private function setVars()
    {

        if ($this->renew) {
            $this->room->load('roomActive');
            $detail = ClientRoom::where('room_id', $this->room->id)
                ->where('client_id', $this->room->roomActive[0]->id)
                ->where('invoiced', false)
                ->orderBy('date_out', 'desc')
                ->first();
            $this->now = Carbon::parse($detail->date_out);
        } else {
            $this->now = Carbon::now();
        }
        $this->acum = $this->room->partialCost->rate;
        $this->dayName = $this->now->locale('es')->dayName;
        $this->date = $this->now->format('m/d');
    }


    public function getRateByConditionals()
    {

        $rate = $this->acum;

        $rate = self::getRateByDay($this->dayName);
        if ($rate == 0) {
            $rate = self::getRateByRange();
        }
        if ($rate == 0) {
            $rate = self::getRateByDate($this->date);
        }
        if ($rate == 0) {
            $rate = self::getRateByHour();
        }

        return $rate == 0 ? $this->acum : $rate;
    }

    private function getRateByRange(): int
    {
        // falta mostrar todo lo que se esta aplicando para mostrarlo en el detalle de ñla habitacion

        $day_template = RangeTemplate::where('room_type_id', $this->room_type_id)
            ->where('date_start', '<=', $this->now)
            ->where('date_end', '>=', $this->now)
            ->first();

        if ($day_template != '') {
            if (!$this->bool_date) {
                self::getPartialCostByRoomTypeAndPartial($day_template->room_type_id, $day_template->partial_rate_id);
            }
            return (int) $day_template->rate;
        }
        return 0;
    }

    private function getRateByDay($dayNameCurrent): int
    {
        // falta mostrar todo lo que se esta aplicando para mostrarlo en el detalle de ñla habitacion

        $day_template = DayTemplate::whereHas('dayWeek', function (Builder $builder) use ($dayNameCurrent) {
            return $builder->where(
                DB::raw('lower(name)'),
                'like',
                DB::raw("lower('$dayNameCurrent')")
            );
        })
            ->where('room_type_id', $this->room_type_id)
            ->first();

        if ($day_template != '') {
            if(self::verifyHourOfRegister($day_template->hour_start, $day_template->hour_end)) {
                if (!$this->bool_date) {
                    self::getPartialCostByRoomTypeAndPartial($day_template->room_type_id, $day_template->partial_rate_id);
                }
                return (int) $day_template->rate;
            }
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
        $date_template = DateTemplate::where('date', $dateCurrent)
            ->where('room_type_id', $this->room_type_id)
            ->first();
        if ($date_template != '') {
            if(self::verifyHourOfRegister($date_template->hour_start, $date_template->hour_end)) {
                self::getPartialCostByRoomTypeAndPartial($date_template->room_type_id, $date_template->partial_rate_id);

                return (int) $date_template->rate;
            }
        }
        return 0;
    }


    private function verifyHourOfRegister(string $hour_init,string $hour_end){
        $init = explode(':',$hour_init);
        $end = explode(':',$hour_end);

        if(
            $this->now >= Carbon::now()->setHour($init[0])->setMinute($init[1])
            && $this->now <= Carbon::now()->setHour($end[0])->setMinute($end[1])
        ){
            return true;
        }
        return false;
    }

    private function getRateByHour(): int
    {
        $hour_template = HourTemplate::where('room_type_id', $this->room_type_id)
            ->get();

        if ($hour_template->count() == 0) {
            return 0;
        }

        $now = Carbon::now();
        $bool = $hour_template->map(function ($hour) use ($now) {
            $start = self::setHourByString($hour->hour);
            $end = self::setHourByString($hour->hour_end);
            if ($now >= $start && $now <= $end) {
                return $hour;
            }
        })->filter()->first();
        if ($bool != '') {
            if (!$this->bool_date) {

                self::getPartialCostByRoomTypeAndPartial($bool->room_type_id, $bool->partial_rate_id);
            }
            return (int) $bool->rate;
        }
        return 0;
    }

    private function setHourByString(string $hour_start): Carbon
    {
        $hour = explode(':', $hour_start);
        $now = Carbon::now();
        $now->hour   = $hour[0];
        $now->minute = $hour[1];

        return $now;
    }

    public function getPartialByConditionals()
    {
        $this->bool_date =false;
        self::getRateByDay($this->dayName);
        if ($this->bool_date ) {
            self::getRateByDate($this->date);
        }

        return $this->partial_min;
    }

    private function updatePartialCost(int $partial_cost_id)
    {
        // $this->room->update(['partial_cost_id' => $partial_cost_id]);
    }

    private function getPartialCostByRoomTypeAndPartial(int $room_type_id, int $partial_rate_id)
    {
        $partial_cost =  \App\Models\PartialCost::where('room_type_id', $room_type_id)
            ->where('partial_rates_id', $partial_rate_id)
            ->first();

        if ($partial_cost == '') {
            return $this->room->partial_cost_id;
        }
        $this->bool_date = true;
        // self::updatePartialCost($partial_cost->id);
        // dump($partial_cost->id);
        return $this->partial_min = $partial_cost->id;
    }

    private function getRateOfConditionals()
    {

        if ($this->partial_init == $this->partial_min) return 0;
        $partial_cost = \App\Models\PartialCost::find($this->partial_min);

        return $partial_cost->rate;
    }
}
