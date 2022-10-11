<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class PartialRates extends Authenticatable implements Auditable
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
     * get number of name
     *
     * @return bool
     */
    public function getNumberHourAttribute()
    {
        return rtrim($this->attributes['name'],'h');
    }
}
