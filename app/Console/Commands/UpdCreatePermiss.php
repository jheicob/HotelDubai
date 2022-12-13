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
        $this->info('Creando/Actualizando permisos ');

        $role = $this->choice('Quieres asignarle este permiso a',[
            'todos',
            'Admin',
        ]);
        $permiss_news = [
            'inventory',
            'punto_venta.report',
            'punto_venta.report.graph',
            'FiscalMachines.index',
            'FiscalMachines.create',
            'FiscalMachines.delete',
            'FiscalMachines.updated',
            'FiscalMachines.getPaginate',
            'FiscalMachines.get',

            'ProductCategory.index',
            'ProductCategory.create',
            'ProductCategory.delete',
            'ProductCategory.updated',
            'ProductCategory.getPaginate',
            'ProductCategory.get',
        ];

        foreach($permiss_news as $new){
            if(!Permission::firstWhere('name',$new)){
                Permission::create(['name'=>$new]);
            }
        }

        $this->info('Asignando permisos para: '. $role);

        if($role == 'todos'){
            $roles = Role::all();
            $roles->map(function($role) use ($permiss_news){
                $role->givePermissionTo($permiss_news);
            });
        }else{
            $roles = Role::find(1);
            $roles->givePermissionTo($permiss_news);

        }


        $this->info('permisos terminados');
        return 0;
    }
}
