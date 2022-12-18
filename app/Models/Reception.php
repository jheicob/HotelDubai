<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class Reception extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable=[
        'client_id',
        'room_id',
        'date_in',
        'date_out',
        'invoiced',
        'observation',
        'invoice_id',
        'reservation'
    ];

    protected $auditInclude = [
        'client_id',
        'room_id',
        'reservation',
        'date_in',
        'date_out',
        'observation',
        'invoiced',
        'invoice_id'

    ];

    public function getDateInAttribute($value){
        return Carbon::parse($value)->format('Y-m-d H:i');
    }

    public function getDateOutAttribute($value){
        return Carbon::parse($value)->format('Y-m-d H:i');
    }

    public function details(){
        return $this->hasMany(ReceptionDetail::class);
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function room(){
        return $this->belongsTo(Room::class);
    }

    public function scopeFilter(Builder $query, $request){
        return $query
            ->when($request->room_type_id, function(Builder $q,$room_type_id){
                return $q->whereHas('room', function(Builder $q) use ($room_type_id){
                    $q->where('room_type_id', $room_type_id);
                });
            });
    }

    public function companions(){
        return $this->hasMany(Companion::class);
    }

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }

    public function invoiceDetail(){
        return $this->hasOneThrough(InvoiceDetail::class,ReceptionDetail::class,'reception_id','productable_id')
                    ->where('productable_type','App\\Models\\ReceptionDetail')
                        ;
    }
}
