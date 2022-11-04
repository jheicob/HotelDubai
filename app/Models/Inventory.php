<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Inventory extends Model implements Auditable
{
    use HasFactory;
    use AuditingAuditable;

    protected $auditInclude = [
        'product_id',
        'stock_min',
        'stock'
    ];

    protected $fillable = [
        'product_id',
        'stock_min',
        'stock'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

}
