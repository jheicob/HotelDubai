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
        'exchange_rate',
        'warning_time',
        'cancel_time',
        'color_warning_time',
        'color_past_time'
    ];

    protected $auditInclude = [
        'exchange_rate',
        'env',
        'fiscal_machine_serial',
        'warning_time',
        'cancel_time',
        'color_warning_time',
        'color_past_time'
    ];

    protected $casts = [
        'env' =>'string',
        'fiscal_machine_serial' =>'string',
        'exchange_rate' => 'float',
        'warning_time' => 'string',
        'cancel_time' => 'string',
        'color_warning_time' => 'json',
        'color_past_time' => 'json'


    ];
}
