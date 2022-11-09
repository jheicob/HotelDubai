<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Repair extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'room_id',
        'report_user',
        'maintenance_user',
        'description',
        'observation',
        'report_date',
        'maintenance_date',
    ];

    protected $auditInclude = [
        'room_id',
        'report_user',
        'maintenance_user',
        'description',
        'observation',
        'report_date',
        'maintenance_date',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function reportUser()
    {
        return $this->belongsTo(User::class, 'report_user');
    }

    public function maintenanceUser()
    {
        return $this->belongsTo(User::class, 'maintenance_user');
    }
}
