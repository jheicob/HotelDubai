<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
        'slash_code',
        'product_category_id'
    ];

    protected $fillable = [
        'name',
        'description',
        'purchase_price',
        'sale_price',
        'visible',
        'slash_code',
        'product_category_id'

    ];

    /**
     * get inventory belong to product
     */
    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }

     public function invoiceDetail(){
        return $this->morphMany(InvoiceDetail::class,'productable');
    }

    public function category() {
        return $this->belongsTo(ProductCategory::class,'product_category_id');
    }

    public function scopeFilter(Builder $query, $request){
        return $query
                ->when($request->search,function(Builder $q,$search){
                    $q->where('name','like',"%$search%")
                        ->orWhere('slash_code','like',"%$search%");
                })
                ->when($request->product_category_id,function(Builder $q,$product_category_id){
                    $q->where('product_category_id',$product_category_id);
                })
                ;
    }
}
