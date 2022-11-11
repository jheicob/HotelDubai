<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class RangeTemplate extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $auditInclude = [
        'room_type_id',
        'partial_rate_id',
        'date_start',
        'date_end',
        'rate',
    ];

    protected $fillable = [
        'room_type_id',
        'partial_rate_id',
        'date_start',
        'date_end',
        'rate',
    ];

    public function getDateStartAttribute()
    {
        return Carbon::parse($this->attributes['date_start'])->format('d-m-Y');
    }

    public function getDateEndAttribute()
    {
        return Carbon::parse($this->attributes['date_end'])->format('d-m-Y');
    }
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function partialRate()
    {
        return $this->belongsTo(PartialRates::class);
    }
}
