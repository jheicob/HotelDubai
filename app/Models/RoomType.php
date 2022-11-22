<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class RoomType extends Authenticatable implements Auditable
{
    use HasFactory,SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'description',
        'name',
    ];

    protected $auditInclude = [
        'description',
        'name',
    ];

    /**
     * Get all of the partialCost for the RoomType
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function partialCost()
    {
        return $this->hasMany(PartialCost::class);
    }

    public function room(){
        return $this->hasOneThrough(Room::class,PartialCost::class);
    }
}
