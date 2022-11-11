<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class HourTemplate extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'room_type_id',
        'shift_system_id',
        'partial_rate_id',
        'rate',
        'hour',
        'hour_end'
    ];

    protected $auditInclude = [
        'room_type_id',
        'shift_system_id',
        'rate',
        'partial_rate_id',
        'hour',
        'hour_end'
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function shiftSystem()
    {
        return $this->belongsTo(ShiftSystem::class);
    }

    public function estateType()
    {
        return $this->belongsTo(EstateType::class);
    }

    public function partialRate(){
        return $this->belongsTo(PartialRates::class);
    }
}
