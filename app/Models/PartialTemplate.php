<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class PartialTemplate extends Authenticatable implements Auditable
{
    use HasFactory,SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
    'room_type_id',
    'day_week_id',
    'system_time_id',
    'shift_system_id',
    'partial_rates_id',
    ];

    protected $auditInclude = [
    'room_type_id',
    'day_week_id',
    'system_time_id',
    'shift_system_id',
    'partial_rates_id',
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

    public function dayWeek()
    {
        return $this->belongsTo(DayWeek::class, 'day_week_id');
    }

    public function systemTime()
    {
        return $this->belongsTo(SystemTime::class, 'system_time_id');
    }

    public function shiftSystem()
    {
        return $this->belongsTo(ShiftSystem::class, 'shift_system_id');
    }

    public function partialRate()
    {
        return $this->belongsTo(PartialRates::class, 'partial_rates_id');
    }
}
