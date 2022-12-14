<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class TypeDocument extends Model implements Auditable
{
    use SoftDeletes,HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id'];

    protected $auditInclude = [
        'name',
        'description'
    ];

    protected $fillable = [
        'name',
        'description'
    ];
}
