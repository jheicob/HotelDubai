<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RoomNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_name',
        'status_new',
        'message',
        'view',
    ];

    public function scopeFilter(Builder $query, $request){
        return $query->when(Auth::user()->roles[0]->name == 'Camarero', function(Builder $q){
            $q->where('status_new','Sucia');
        })
        ->when(Auth::user()->roles[0]->name == 'Mantenimiento', function(Builder $builder){
            $builder->where('status_new','Fuera de Servicio');
        });
        ;
    }

}
