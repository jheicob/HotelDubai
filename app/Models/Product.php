<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Product extends Model implements Auditable
{
    use SoftDeletes, HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id'];

    protected $auditInclude = [
        'name',
        'description',
        'purchase_price',
        'sale_price',
        'visible',
    ];

    protected $fillable = [
        'name',
        'description',
        'purchase_price',
        'sale_price',
        'visible',

    ];

    /**
     * get inventory belong to product
     */
    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }
}