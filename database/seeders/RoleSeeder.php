<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Admin              = Role::create(['name' => 'Admin']);
        $recepcionista_cab  = Role::create(['name' => 'Recepcionista Cabaña']);
        $recepcionista_ed   = Role::create(['name' => 'Recepcionista Edificio']);
        $mantenimiento      = Role::create(['name' => 'Mantenimiento']);
        $camarero_role      = Role::create(['name' => 'Camarero']);
        $supervisor_role    = Role::create(['name' => 'Supervisor']);

        (User::find(1))->assignRole('Admin');
        (User::firstWhere('email', "recepcionistaCab@c.c"))->assignRole('Recepcionista Cabaña');
        (User::firstWhere('email', "recepcionistaEd@c.c"))->assignRole('Recepcionista Edificio');
        (User::firstWhere('email', "camarero@c.c"))->assignRole('Camarero');
        (User::firstWhere('email', "mantenimiento@c.c"))->assignRole('Mantenimiento');
        (User::firstWhere('email', "supervisor@c.c"))->assignRole('Supervisor');

        $Admin->givePermissionTo(
            [
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
            ]
        );

        $recepcionista_ed->givePermissionTo([
            'notification.room.sucia',
            'notification.room.maintenance',
            'notification.room.disponible',

            'room.index',
            'estate.type.getPaginate',
            'room.getPaginate',
            'room.get',
            'room.occuppy',
            'room.status.getPaginate',
            'room.changeParcial',

            'partial.cost.getPaginate',
            'room.type.getPaginate',
            'room.extend',

            'invoice.index',
            'invoice.create',
            'invoice.getPaginate',
            'invoice.get',
            'invoice.reportX',
            'invoice.printFiscal',

            'client.index',
            'client.create',
            'client.delete',
            'client.cancel.room',
            'client.updated',
            'client.getPaginate',
            'client.get',
            'client.assigned_room',

            'product.getPaginate',
        ]);
        $recepcionista_cab->givePermissionTo([
            'notification.room.sucia',
            'notification.room.maintenance',
            'notification.room.disponible',

            'room.index',
            'estate.type.getPaginate',
            'room.getPaginate',
            'room.get',
            'room.occuppy',
            'room.status.getPaginate',
            'room.changeParcial',

            'partial.cost.getPaginate',
            'room.type.getPaginate',
            'room.extend',

            'product.getPaginate',
            'invoice.index',
            'invoice.create',
            'invoice.getPaginate',
            'invoice.get',
            'invoice.printFiscal',
            'invoice.reportX',


            'client.index',
            'client.create',
            'client.delete',
            'client.cancel.room',
            'client.updated',
            'client.getPaginate',
            'client.get',
            'client.assigned_room',

        ]);

        $camarero_role->givePermissionTo([
            'notification.room.ocuppy',
            'notification.room.sucia',
            'notification.room.disponible',

            'room.index',
            'partial.cost.getPaginate',
            'room.free',
            'room.getPaginate',
            'estate.type.getPaginate',
            'room.get',
            'room.type.getPaginate',
            'room.status.getPaginate',
            'room.free', 'room.in_repair',

        ]);

        $mantenimiento->givePermissionTo([
            'notification.room.ocuppy',
            'notification.room.maintenance',

            'room.index',
            'partial.cost.getPaginate',
            'room.free',
            'room.getPaginate',
            'estate.type.getPaginate',
            'room.get',
            'room.type.getPaginate',
            'room.status.getPaginate',
            'room.free',
            'room.repair',
        ]);

        $supervisor_role->givePermissionTo([
            'notification.room.ocuppy',
            'notification.room.sucia',
            'notification.room.maintenance',
            'notification.room.disponible',

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
        ]);
    }
}
