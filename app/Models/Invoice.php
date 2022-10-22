<?php

namespace App\Models;

use Carbon\Carbon;
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
        'observation'.
        'cancelled',
    ];

    protected $fillable = [
        'date',
        'client_id',
        'total',
        'observation',
        'num_fiscal',
        'date_fiscal',
        'cancelled',
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function details(){
        return $this->hasMany(InvoiceDetail::class);
    }

 /*   public function setDateAttribute($value){
        $this->attributes['date'] = Carbon::now()->format('Y-m-d H:i:s');
 }*/

}
