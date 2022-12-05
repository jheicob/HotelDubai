<?php

namespace App\Console\Commands;

use App\Models\Role;
use Illuminate\Console\Command;

class RestorePermissAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'restore-permiss:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setea desde cero los permisos del admin';

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

        $role = Role::firstWhere('name','Admin');

        if($role == ''){
            $this->info('No existe el rol Admin');
            return 0;

        }

        $role->givePermissionTo([
            'seguridad',
            'permissions.index',
            'permissions.create',
            'permissions.delete',
            'permissions.updated',
            'permissions.getPaginate',

            'roles.index',
            'roles.create',
            'roles.delete',
            'roles.updated',
            'roles.getPaginate',
            'logs.index',
            'logs.getPaginate',

            'users.index',
            'users.create',
            'users.delete',
            'users.updated',
            'users.getPaginate',

            'configuracion',

            'room.type.index',
            'room.type.create',
            'room.type.delete',
            'room.type.updated',
            'room.type.getPaginate',
            'room.type.get',

            'theme.type.index',
            'theme.type.create',
            'theme.type.delete',
            'theme.type.updated',
            'theme.type.getPaginate',
            'theme.type.get',

            'estate.type.index',
            'estate.type.create',
            'estate.type.delete',
            'estate.type.updated',
            'estate.type.getPaginate',
            'estate.type.get',

            'partial.rates.index',
            'partial.rates.create',
            'partial.rates.delete',
            'partial.rates.updated',
            'partial.rates.getPaginate',
            'partial.rates.get',

            'room.status.index',
            'room.status.create',
            'room.status.delete',
            'room.status.updated',
            'room.status.getPaginate',
            'room.status.get',

            'tarifas',
            'partial.cost.index',
            'partial.cost.create',
            'partial.cost.delete',
            'partial.cost.updated',
            'partial.cost.getPaginate',
            'partial.cost.get',

            'partial.templates.index',
            'partial.templates.create',
            'partial.templates.delete',
            'partial.templates.updated',
            'partial.templates.getPaginate',
            'partial.templates.get',

            'day.week.index',
            'day.week.create',
            'day.week.delete',
            'day.week.updated',
            'day.week.getPaginate',
            'day.week.get',

            'system.time.index',
            'system.time.create',
            'system.time.delete',
            'system.time.updated',
            'system.time.getPaginate',
            'system.time.get',

            'shift.system.index',
            'shift.system.create',
            'shift.system.delete',
            'shift.system.updated',
            'shift.system.getPaginate',
            'shift.system.get',


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

            'room.index',
            'room.create',
            'room.delete',
            'room.updated',
            'room.getPaginate',
            'room.get',
            'room.occuppy',
            'room.free',
            'room.changeParcial',
            'room.extend',
            'room.in_repair',
            'room.repair',

            'day.templates.index',
            'day.templates.create',
            'day.templates.delete',
            'day.templates.updated',
            'day.templates.getPaginate',
            'day.templates.get',

            'client.index',
            'client.create',
            'client.delete',
            'client.updated',
            'client.getPaginate',
            'client.cancel.room',
            'client.get',
            'client.report',
            'client.assigned_room',

            'invoice.index',
            'invoice.create',
            'invoice.delete',
            'invoice.updated',
            'invoice.getPaginate',
            'invoice.get',
            'invoice.printFiscal',
            'invoice.cancel',
            'invoice.reportX',
            'invoice.reportZ',

            'product.index',
            'product.create',
            'product.delete',
            'product.updated',
            'product.getPaginate',
            'product.get',

            'repair.index',
            'repair.create',
            'repair.delete',
            'repair.updated',
            'repair.getPaginate',
            'repair.get',

            'configuration.upsert',
            'configuration.getPaginate',
            'configuration.index',

            'range.template.index',
            'range.template.create',
            'range.template.delete',
            'range.template.updated',
            'range.template.getPaginate',
            'range.template.get',

            'notification.room.ocuppy',
            'notification.room.sucia',
            'notification.room.maintenance',
            'notification.room.disponible',

            'extra-guest.index',
            'extra-guest.create',
            'extra-guest.delete',
            'extra-guest.updated',
            'extra-guest.getPaginate',
            'extra-guest.get',

            'room.report',
            'roomType.report',
            'reception.report',
            'reports',

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
