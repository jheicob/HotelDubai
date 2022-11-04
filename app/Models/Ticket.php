<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Ticket extends Model implements Auditable
{
    use HasFactory;
    use AuditingAuditable;

    protected $fillable = [
        'reception_detail_id',
        'observation'
    ]; 
    protected $auditInclude = [
        'reception_detail_id',
        'observation'
    ];

    public function receptionDetail(){
    return $this->belongsTo(ReceptionDetail::class);
    }
}
