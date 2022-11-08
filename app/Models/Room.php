<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;

class Room extends Model implements Auditable
{
    use SoftDeletes, HasFactory;
    use \OwenIt\Auditing\Auditable;

    // fields to save massive
    protected $fillable = [
        'room_status_id',
        'partial_cost_id',
        'description',
        'name',
        'estate_type_id',
    ];

    // fields to audit
    protected $auditInclude = [
        'room_status_id',
        'partial_cost_id',
        'estate_type_id',
        'description',
        'name'
    ];

    public function roomStatus()
    {
        return $this->belongsTo(RoomStatus::class);
    }

    public function estateType()
    {
        return $this->belongsTo(EstateType::class);
    }

    // get the partialCost that belongs to this room
    public function partialCost()
    {
        return $this->belongsTo(PartialCost::class);
    }

    /**
     * get the clients that belongs many to this room
     */
    public function clients()
    {
        return $this->belongsToMany(Client::class)->using(ClientRoom::class);
    }

    /**
     * obtiene el cuarto que esta activo
     *
     * @return void
     */
    public function roomActive()
    {
        return $this->belongsToMany(Client::class)
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

    protected $casts = [];
    public function receptions()
    {
        return $this->hasMany(Reception::class);
    }

    public function receptionActive()
    {
        return $this->receptions()->where('invoiced', false);
    }

    public function scopeIsCamarero(Builder $query)
    {
        $role = Auth::user()->roles->first();

        return $query->when($role->name == 'Camarero', function (Builder $q) {
            return $q->where('room_status_id', 1); // 1 is Sucia
        });
    }

    public function scopeIsMantenimiento(Builder $query)
    {
        $role = Auth::user()->roles->first();

        return $query->when($role->name == 'Mantenimiento', function (Builder $q) {
            return $q->where('room_status_id', 3); // 1 is Sucia
        });
    }

    public function scopeIsNotAdmin(Builder $query)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $role = $user->roles->first();

        if ($role->name != 'Admin') {
            $rol = Role::find($role->id);
            $id_estate = [];

            foreach ($rol->estateTypes as $estateType) {
                $id_estate[] = $estateType['id'];
            }
            return $query->whereIn('estate_type_id', $id_estate);
        }
    }
}
