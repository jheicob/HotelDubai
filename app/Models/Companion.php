<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Companion extends Model implements Auditable
{
    use HasFactory;
    use AuditingAuditable;

    protected $fillable = [
        'client_id',
        'extra_guest_id',
        'reception_id',
    ];

    protected $auditInclude = [
        'client_id',
        'extra_guest_id',
        'reception_id',
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function extraGuest(){
        return $this->belongsTo(ExtraGuest::class);
    }

    public function reception(){
        return $this->belongsTo(Reception::class);
    }
}
