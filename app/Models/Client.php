<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;

class Client extends Model implements Auditable
{
    use SoftDeletes, HasFactory;
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

    public function typeDocument()
    {
        return $this->belongsTo(TypeDocument::class);
    }
    public function scopeFilter(Builder $query, $request)
    {
        return $query
            ->when($request->document, function (Builder $q, $document) {
                return $q->where('document', $document);
            });
    }

    // get the rooms of user
    public function rooms()
    {
        return $this->belongsToMany(Room::class)
            ->using(ClientRoom::class)
            ->withPivot([
                'date_in',
                'date_out',
                'partial_min',
                'rate',
                'observation',
                'quantity_partial',
                'time_additional',
                'price_additional',
                'invoiced'
            ]);
    }

    public function receptions()
    {
        return $this->hasMany(Reception::class);
    }

    /**
     * obtiene el cuarto que esta activo
     *
     * @return void
     */
    public function roomActive()
    {
        return $this->belongsToMany(Room::class)
            ->using(ClientRoom::class)
            ->withPivot([
                'date_in',
                'date_out',
                'partial_min',
                'rate',
                'observation',
                'quantity_partial',
                'time_additional',
                'price_additional',
                'invoiced'
            ])
            ->wherePivot('invoiced', false);
    }

    public function invoiceNoPrint() {
        return $this
                    ->hasOne(Invoice::class)
                    ->where('status','Sin Imprimir')
                    ->orderBy('id','desc')
                    ;
    }

    public function receptionActive()
    {
        return $this->hasMany(Reception::class)
            ->where('invoiced', false)
            ->where('reservation',0)
            ->orderBy('id','desc')
            ;
    }

    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

    public function receptionClosed(){
        return $this->hasMany(Reception::class)
                    ->where('invoiced',1)
                    ->where('reservation',0);

                    ;
    }
}
