<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Configuration extends Model implements Auditable
{
    use HasFactory, AuditingAuditable;

    protected $fillable = [
        'env',
        'fiscal_machine_serial',
        'exchange_rate'
    ];

    protected $auditInclude = [
        'exchange_rate',
        'env',
        'fiscal_machine_serial'
    ];
}
