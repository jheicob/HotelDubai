<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Room extends Model implements Auditable
{
    use SoftDeletes, HasFactory;
    use \OwenIt\Auditing\Auditable;

    // fields to save massive
    protected $fillable = [
        'room_status_id',
        'partial_cost_id',
        'description',
        'name'
    ];

    // fields to audit
    protected $auditInclude = [
        'room_status_id',
        'partial_cost_id',
        'description',
        'name'

    ];

    public function roomStatus(){
        return $this->belongsTo(RoomStatus::class);
    }


    // get the partialCost that belongs to this room
    public function partialCost()
    {
        return $this->belongsTo(PartialCost::class);
    }

    /**
     * get the clients that belongs many to this room
     */
    public function clients(){
        return $this->belongsToMany(Client::class)->using(ClientRoom::class);
    }
}
