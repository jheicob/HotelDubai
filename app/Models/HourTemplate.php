<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HourTemplate extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'room_type_id',
        'shift_system_id',
        'rate',
        'hour'
    ];

    public function roomType(){
        return $this->belongsTo(RoomType::class);
    }

    public function shiftSystem(){
        return $this->belongsTo(ShiftSystem::class);
    }
}
