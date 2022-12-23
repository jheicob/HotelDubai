<?php

namespace App\Console\Commands;

use App\Models\RoomStatus;
use Illuminate\Console\Command;

class SetEstatusReservationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set-estatus:reservation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea el estado de reservado';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Se creará el estado Reservada');

        RoomStatus::create( [
            'name' => 'Reservada',
            'description' => 'Reservada',
            'color' => '{"css": "background-color:rgba(118,183,79,1)", "mode": "solid", "color": {"a": 1, "b": 79, "g": 183, "r": 118}}'
        ]);
        $this->info('El estado de reservado se ha creado exitosamente');
        return 0;
    }
}
