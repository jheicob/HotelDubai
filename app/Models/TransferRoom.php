<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Audit as AuditingAudit;
use OwenIt\Auditing\Contracts\Audit;

class TransferRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_origin',
        'room_destiny',
        'motive',
        'observation'
    ];


    protected $auditInclude = [
        'room_origin',
        'room_destiny',
        'motive',
        'observation'
    ];

    public function roomOrigin()
    {
        return $this->belongsTo(Room::class, 'room_origin');
    }

    public function roomDestiny()
    {
        return $this->belongsTo(Room::class, 'room_destiny');
    }
}
