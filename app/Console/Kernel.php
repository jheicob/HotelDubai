<?php

namespace App\Console;

use App\Jobs\VerifyReservationJob;
use App\Models\Reception;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->job(new VerifyReservationJob)->everyMinute()->when(function(){
            $now = Carbon::now();

            $receptions = Reception::where('date_in','<=',$now->format('Y-m-d H:i:s'))
            ->where('date_out','>=',Carbon::now()->endOfDay()->format('Y-m-d H:i:s'))
            // ->where('invoiced',0)
            ->where('reservation',1)
            ->with('room')
            ->whereHas('room', function(Builder $query){
                $query->whereHas('roomStatus',function(Builder $query){
                    $query->where('name','Disponible');
                });
            })
            ->get();

            return $receptions->count() > 0;
        });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
