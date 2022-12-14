<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class DayTemplate extends Model implements Auditable
{
    use SoftDeletes, HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id'];

    protected $fillable = [
        'room_type_id',
        'day_week_id',
        'partial_rate_id',
        'rate',
        'hour_start',
        'hour_end'
    ];

    protected $auditInclude = [
        'room_type_id',
        'partial_rate_id',
        'day_week_id',
        'rate',
        'hour_start',
        'hour_end'
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    /**
     * Get the dayWeek that owns the DayTemplate
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dayWeek()
    {
        return $this->belongsTo(DayWeek::class);
    }

    public function partialRate()
    {
        return $this->belongsTo(PartialRates::class);
    }
}
