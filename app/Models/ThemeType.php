<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;


class ThemeType extends Authenticatable implements Auditable
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
     * Get all of the rooms for the ThemeType
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
