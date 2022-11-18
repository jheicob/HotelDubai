<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class InvoiceDetail extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'invoice_id',
        'productable_id',
        'productable_type',
        'price',
        'quantity',
        'description',
    ];

    protected $auditInclude = [
        'invoice_id',
        'productable_id',
        'description',
        'productable_type',
        'price',
        'quantity',
    ];

    public function productable(){
        return $this->morphTo();
    }

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
}
