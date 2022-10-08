<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Room extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'room_status_id',
        'partial_rate_id',
        'theme_type_id',
        'description',
        'rate'
    ];

    protected $auditInclude = [
        'room_status_id',
        'partial_rate_id',
        'theme_type_id',
        'description',
        'rate'
    ];

    public function partialRate(){
        return $this->belongsTo(PartialRates::class);
    }
    public function roomStatus(){
        return $this->belongsTo(RoomStatus::class);
    }

    /**
     * Get the partialTemplate that owns the Room
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    /**
     * Get the themeType that owns the Room
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function themeType()
    {
        return $this->belongsTo(ThemeType::class);
    }
}
