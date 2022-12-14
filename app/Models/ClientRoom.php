<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ClientRoom extends Pivot
{

    protected $fillable = [
        'client_id',
        'room_id',
        'date_in',
        'date_out',
        'partial_min',
        'rate',
        'observation',
        'quantity_partial',
        'time_additional',
        'price_additional',
        'invoiced'
    ];

    public function getDateInAttribute($value){
        return Carbon::parse($value)->format('Y-m-d H:i');
    }

    public function getDateOutAttribute($value){
        return Carbon::parse($value)->format('Y-m-d H:i');
    }
}
