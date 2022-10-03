<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DateTemplate extends Model
{
    use
        HasFactory,
        SoftDeletes
    ;

    protected $fillable = [
        'room_type_id',
        'date',
        'rate'
    ];

    public function roomType(){
        return $this->belongsTo(RoomType::class);
    }
}
