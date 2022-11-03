<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class DateTemplate extends Model implements Auditable
{
    use
        HasFactory,
        SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'room_type_id',
        'partial_rate_id',
        'date',
        'rate'
    ];
    protected $auditInclude = [
        'room_type_id',
        'date',
        'partial_rate_id',
        'rate'
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function partialRate()
    {
        return $this->belongsTo(PartialRates::class);
    }
}
