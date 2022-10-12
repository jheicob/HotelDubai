<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;

class Client extends Model implements Auditable
{
    use SoftDeletes,HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id'];

    protected $auditInclude = [
        'document',
        'first_name',
        'last_name',
        'phone',
        'email',
        'type_document_id'

    ];

    protected $fillable = [
        'document',
        'first_name',
        'last_name',
        'phone',
        'email',
        'type_document_id'
    ];

    public function scopeFilter(Builder $query,$request){
        return $query
                ->when($request->document,function(Builder $q,$document){
                    return $q->where('document',$document);
                });
    }

    // get the rooms of user
    public function rooms()
    {
        return $this->belongsToMany(Room::class)->using(ClientRoom::class);
    }
}
