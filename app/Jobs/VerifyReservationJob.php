<?php

namespace App\Jobs;

use App\Models\Reception;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class VerifyReservationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('ejecutando job para cambiar las reservaciones');
        $now = Carbon::now();
        Log::info('Fecha completa:'.$now->format('d-m-Y H:i:s'));

        $receptions = Reception::where('date_in','<=',$now->format('Y-m-d H:i:s'))
                        ->where('invoiced',0)
                        ->where('reservation',1)
                        ->with('room')
                        ->whereHas('room', function(Builder $query){
                            $query->whereHas('roomStatus',function(Builder $query){
                                $query->where('name','Disponible');
                            });
                        })
                        ->get();
        Log::info('cantidad de reservadas que serán cambiadas se han encontrado:'.$receptions->count());
        foreach ($receptions as $reception) {
            Log::info($reception->id);

            $reception->room->update(['room_status_id'=> 5]);
        }
    }
}
