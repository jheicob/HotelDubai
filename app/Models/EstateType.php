<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class EstateType extends Authenticatable implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'description',
        'name',
    ];

    protected $auditInclude = [
        'description',
        'name',
    ];

    public function receptions(){
        return $this->hasManyThrough(Reception::class,Room::class);
    }

    public function rooms(){
        return $this->hasMany(Room::class);
    }
}
