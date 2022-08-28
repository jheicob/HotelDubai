<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class PartialCost extends Authenticatable implements Auditable
{
    use HasFactory,SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        "room_type_id",
        "partial_rates_id",
        "rate",
    ];

    protected $auditInclude = [
        "room_type_id",
        "partial_rates_id",
        "rate",
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

    public function partialRate()
    {
        return $this->belongsTo(PartialRates::class, 'partial_rates_id');
    }
}
