<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class FiscalMachine extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id'];

    protected $auditInclude = [
        'name',
        'serial',
        'estate_type_id',
    ];

    public function estateType(){
        return $this->belongsTo(\App\Models\EstateType::class,'estate_type_id');
    }

    public function scopeFilter(Builder $query, $request){
        return $query->when($request->estate_type_id,function(Builder $q,$estate_type_id){
            return $q->where('estate_type_id',$estate_type_id);
        });
    }
}
