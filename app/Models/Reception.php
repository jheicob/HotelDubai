<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Carbon\Carbon;
class Reception extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable=[
        'client_id',
        'room_id',
        'date_in',
        'date_out',
        'invoiced'
    ];

    protected $auditInclude = [
        'client_id',
        'room_id',
        'date_in',
        'date_out',
        'invoiced'
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
}
