<?php

namespace App\Console\Commands;

use App\Models\Role;
use Illuminate\Console\Command;

class UpdatePermissToSupervisor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'restore-permiss:supervisor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setea desde cero los permisos del supervisor';

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
        $this->info('Se reiniciaran los permisos para el rol Supervisor');

        $supervisor = Role::firstWhere('name','Supervisor');

        if($supervisor == ''){
            $this->info('No existe el rol Supervisor');
            return 0;

        }

        $supervisor->givePermissionTo([
            'notification.room.ocuppy',
            'notification.room.sucia',
            'notification.room.maintenance',
            'notification.room.disponible',
            'configuration.getPaginate',

            'room.index',
            'estate.type.getPaginate',
            'room.getPaginate',
            'room.changeParcial',
            'room.get',
            'partial.cost.getPaginate',
            'room.type.getPaginate',
            'room.occuppy',
            'room.status.getPaginate',

            'room.extend',

            'invoice.index',
            'invoice.create',
            'invoice.getPaginate',
            'invoice.get',
            'invoice.printFiscal',
            'invoice.reportX',
            'invoice.reportZ',

            'client.index',
            'client.create',
            'client.cancel.room',
            'client.delete',
            'client.updated',
            'client.getPaginate',
            'client.get',
            'client.assigned_room',

            'client.report',
            'product.index',
            'product.create',
            'product.delete',
            'product.updated',
            'product.getPaginate',
            'product.get',
            'room.free',
            'room.repair',
            'room.in_repair',
            'extra-guest.getPaginate',

            'tarifas',
            'partial.cost.index',
            'partial.cost.create',
            'partial.cost.delete',
            'partial.cost.updated',
            'partial.cost.getPaginate',
            'partial.cost.get',



            'range.template.index',
            'range.template.create',
            'range.template.delete',
            'range.template.updated',
            'range.template.getPaginate',
            'range.template.get',

            'day.templates.index',
            'day.templates.create',
            'day.templates.delete',
            'day.templates.updated',
            'day.templates.getPaginate',
            'day.templates.get',

            'date.templates.index',
            'date.templates.create',
            'date.templates.delete',
            'date.templates.updated',
            'date.templates.getPaginate',
            'date.templates.get',

            'hour.templates.index',
            'hour.templates.create',
            'hour.templates.delete',
            'hour.templates.updated',
            'hour.templates.getPaginate',
            'hour.templates.get',


            'extra-guest.index',
            'extra-guest.create',
            'extra-guest.delete',
            'extra-guest.updated',
            'extra-guest.getPaginate',
            'extra-guest.get',

            'inventory',
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
        ]);
        $this->info('listo');
        return 0;
    }
}
