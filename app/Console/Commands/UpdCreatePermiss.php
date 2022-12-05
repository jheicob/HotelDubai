<?php

namespace App\Console\Commands;

use App\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class UpdCreatePermiss extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updcreate-permiss';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'restablecer permisos';

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
        $this->info('Creando/Actualizando permisos de maquina fiscal');

        Permission::create(['name'=>'FiscalMachines.index']);
        Permission::create(['name'=>'FiscalMachines.create']);
        Permission::create(['name'=>'FiscalMachines.delete']);
        Permission::create(['name'=>'FiscalMachines.updated']);
        Permission::create(['name'=>'FiscalMachines.getPaginate']);
        Permission::create(['name'=>'FiscalMachines.get']);

        $this->info('Asignando permisos para el Testing y el Supervisor');

        $admin = Role::firstWhere('name','Admin');
        $supervisor = Role::firstWhere('name','Supervisor');

        $admin->givePermissionTo([
            'FiscalMachines.index',
            'FiscalMachines.create',
            'FiscalMachines.delete',
            'FiscalMachines.updated',
            'FiscalMachines.getPaginate',
            'FiscalMachines.get',
        ]);
        $supervisor->givePermissionTo([
            'FiscalMachines.index',
            'FiscalMachines.create',
            'FiscalMachines.delete',
            'FiscalMachines.updated',
            'FiscalMachines.getPaginate',
            'FiscalMachines.get',
        ]);

        $this->info('permisos terminados');
        return 0;
    }
}
