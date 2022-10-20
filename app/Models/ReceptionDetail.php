<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ReceptionDetail extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'reception_id',
        'partial_min',
        'rate',
        'observation',
        'quantity_partial',
        'time_additional',
        'price_additional',
    ];

    protected $auditInclude = [
        'reception_id',
        'partial_min',
        'rate',
        'observation',
        'quantity_partial',
        'time_additional',
        'price_additional',
    ];

    public function reception(){
        return $this->belongsTo(Reception::class);
    }
}
