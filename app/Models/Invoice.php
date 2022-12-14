<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Invoice extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;


    protected $auditInclude = [
        'date',
        'client_id',
        'total',
        'num_fiscal',
        'date_fiscal',
        'observation',
        'cancelled',
        'status',
        'total_payment',
        'fiscal_machine_id'
    ];

    protected $fillable = [
        'date',
        'client_id',
        'total',
        'observation',
        'num_fiscal',
        'date_fiscal',
        'cancelled',
        'chanchuyo',
        'status',
        'total_payment',
        'fiscal_machine_id'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function details()
    {
        return $this->hasMany(InvoiceDetail::class);
    }

    /*   public function setDateAttribute($value){
        $this->attributes['date'] = Carbon::now()->format('Y-m-d H:i:s');
 }*/

    public function payments()
    {
        return $this->hasMany(InvoicePayment::class);
    }

    public function fiscalMachine(){
        return $this->belongsTo(FiscalMachine::class);
    }

    public function reception(){
        return $this->hasOne(Reception::class);
    }

    public function scopeChan(Builder $q){
        return $q->where('chanchuyo',0);
    }

    public function scopeNoChan(Builder $q){
        return $q->where('chanchuyo',1);
    }
}
