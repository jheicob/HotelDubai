<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'room_status_id',
        'partial_template_id',
        'theme_type_id',
        'description',
    ];

    public function roomStatus(){
        return $this->belongsTo(RoomStatus::class);
    }

    /**
     * Get the partialTemplate that owns the Room
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partialTemplate()
    {
        return $this->belongsTo(PartialTemplate::class);
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
