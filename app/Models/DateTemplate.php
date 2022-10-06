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
        SoftDeletes
    ;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'room_type_id',
        'date',
        'rate'
    ];
    protected $auditInclude = [
        'room_type_id',
        'date',
        'rate'
    ];

    public function roomType(){
        return $this->belongsTo(RoomType::class);
    }
}
