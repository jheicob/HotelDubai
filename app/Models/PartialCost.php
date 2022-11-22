<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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


    public function rooms(){
        return $this->hasMany(Room::class);
    }
    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

    public function partialRate()
    {
        return $this->belongsTo(PartialRates::class, 'partial_rates_id');
    }

    // function for filter fields of model
    public function scopeFilter(Builder $query, $request){
        return $query
                ->when($request->room_type_id,function(Builder $query,$room_type){
                    return $query->where('room_type_id',$room_type);
                })
                ->when($request->partial_rate_id,function(Builder $query,$partial_rate){
                    return $query->where('partial_rates_id',$partial_rate);
                });
    }
}
