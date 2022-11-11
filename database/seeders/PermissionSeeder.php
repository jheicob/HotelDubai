<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'seguridad']);

        Permission::create(['name' => 'permissions.index']);
        Permission::create(['name' => 'permissions.create']);
        Permission::create(['name' => 'permissions.delete']);
        Permission::create(['name' => 'permissions.updated']);
        Permission::create(['name' => 'permissions.getPaginate']);

        Permission::create(['name' => 'roles.index']);
        Permission::create(['name' => 'roles.create']);
        Permission::create(['name' => 'roles.delete']);
        Permission::create(['name' => 'roles.updated']);
        Permission::create(['name' => 'roles.getPaginate']);

        Permission::create(['name' => 'logs.index']);
        Permission::create(['name' => 'logs.getPaginate']);

        //usuarios

        Permission::create(['name' => 'users.index']);
        Permission::create(['name' => 'users.create']);
        Permission::create(['name' => 'users.delete']);
        Permission::create(['name' => 'users.updated']);
        Permission::create(['name' => 'users.getPaginate']);

        //configuracion

        Permission::create(['name' => 'configuracion']);

        Permission::create(['name' => 'room.type.index']);
        Permission::create(['name' => 'room.type.create']);
        Permission::create(['name' => 'room.type.delete']);
        Permission::create(['name' => 'room.type.updated']);
        Permission::create(['name' => 'room.type.getPaginate']);
        Permission::create(['name' => 'room.type.get']);

        Permission::create(['name' => 'theme.type.index']);
        Permission::create(['name' => 'theme.type.create']);
        Permission::create(['name' => 'theme.type.delete']);
        Permission::create(['name' => 'theme.type.updated']);
        Permission::create(['name' => 'theme.type.getPaginate']);
        Permission::create(['name' => 'theme.type.get']);

        Permission::create(['name' => 'estate.type.index']);
        Permission::create(['name' => 'estate.type.create']);
        Permission::create(['name' => 'estate.type.delete']);
        Permission::create(['name' => 'estate.type.updated']);
        Permission::create(['name' => 'estate.type.getPaginate']);
        Permission::create(['name' => 'estate.type.get']);

        Permission::create(['name' => 'partial.rates.index']);
        Permission::create(['name' => 'partial.rates.create']);
        Permission::create(['name' => 'partial.rates.delete']);
        Permission::create(['name' => 'partial.rates.updated']);
        Permission::create(['name' => 'partial.rates.getPaginate']);
        Permission::create(['name' => 'partial.rates.get']);

        Permission::create(['name' => 'room.status.index']);
        Permission::create(['name' => 'room.status.create']);
        Permission::create(['name' => 'room.status.delete']);
        Permission::create(['name' => 'room.status.updated']);
        Permission::create(['name' => 'room.status.getPaginate']);
        Permission::create(['name' => 'room.status.get']);

        Permission::create(['name' => 'day.week.index']);
        Permission::create(['name' => 'day.week.create']);
        Permission::create(['name' => 'day.week.delete']);
        Permission::create(['name' => 'day.week.updated']);
        Permission::create(['name' => 'day.week.getPaginate']);
        Permission::create(['name' => 'day.week.get']);

        Permission::create(['name' => 'system.time.index']);
        Permission::create(['name' => 'system.time.create']);
        Permission::create(['name' => 'system.time.delete']);
        Permission::create(['name' => 'system.time.updated']);
        Permission::create(['name' => 'system.time.getPaginate']);
        Permission::create(['name' => 'system.time.get']);

        Permission::create(['name' => 'shift.system.index']);
        Permission::create(['name' => 'shift.system.create']);
        Permission::create(['name' => 'shift.system.delete']);
        Permission::create(['name' => 'shift.system.updated']);
        Permission::create(['name' => 'shift.system.getPaginate']);
        Permission::create(['name' => 'shift.system.get']);

        //tarifas

        Permission::create(['name' => 'tarifas']);

        Permission::create(['name' => 'partial.cost.index']);
        Permission::create(['name' => 'partial.cost.create']);
        Permission::create(['name' => 'partial.cost.delete']);
        Permission::create(['name' => 'partial.cost.updated']);
        Permission::create(['name' => 'partial.cost.getPaginate']);
        Permission::create(['name' => 'partial.cost.get']);

        Permission::create(['name' => 'partial.templates.index']);
        Permission::create(['name' => 'partial.templates.create']);
        Permission::create(['name' => 'partial.templates.delete']);
        Permission::create(['name' => 'partial.templates.updated']);
        Permission::create(['name' => 'partial.templates.getPaginate']);
        Permission::create(['name' => 'partial.templates.get']);

        Permission::create(['name' => 'date.templates.index']);
        Permission::create(['name' => 'date.templates.create']);
        Permission::create(['name' => 'date.templates.delete']);
        Permission::create(['name' => 'date.templates.updated']);
        Permission::create(['name' => 'date.templates.getPaginate']);
        Permission::create(['name' => 'date.templates.get']);

        Permission::create(['name' => 'hour.templates.index']);
        Permission::create(['name' => 'hour.templates.create']);
        Permission::create(['name' => 'hour.templates.delete']);
        Permission::create(['name' => 'hour.templates.updated']);
        Permission::create(['name' => 'hour.templates.getPaginate']);
        Permission::create(['name' => 'hour.templates.get']);

        Permission::create(['name' => 'room.index']);
        Permission::create(['name' => 'room.create']);
        Permission::create(['name' => 'room.delete']);
        Permission::create(['name' => 'room.updated']);
        Permission::create(['name' => 'room.getPaginate']);
        Permission::create(['name' => 'room.get']);
        Permission::create(['name' => 'room.occuppy']);
        Permission::create(['name' => 'room.free']);
        Permission::create(['name' => 'room.clean']);
        Permission::create(['name' => 'room.extend']);
        Permission::create(['name' => 'room.changeParcial']);
        Permission::create(['name' => 'room.in_repair']);
        Permission::create(['name' => 'room.repair']);



        Permission::create(['name' => 'day.templates.index']);
        Permission::create(['name' => 'day.templates.create']);
        Permission::create(['name' => 'day.templates.delete']);
        Permission::create(['name' => 'day.templates.updated']);
        Permission::create(['name' => 'day.templates.getPaginate']);
        Permission::create(['name' => 'day.templates.get']);

        Permission::create(['name' => 'client.index']);
        Permission::create(['name' => 'client.create']);
        Permission::create(['name' => 'client.delete']);
        Permission::create(['name' => 'client.updated']);
        Permission::create(['name' => 'client.getPaginate']);
        Permission::create(['name' => 'client.get']);
        Permission::create(['name' => 'client.cancel.room']);
        Permission::create(['name' => 'client.report']);
        Permission::create(['name' => 'client.assigned_room']);

        Permission::create(['name' => 'invoice.index']);
        Permission::create(['name' => 'invoice.create']);
        Permission::create(['name' => 'invoice.delete']);
        Permission::create(['name' => 'invoice.updated']);
        Permission::create(['name' => 'invoice.getPaginate']);
        Permission::create(['name' => 'invoice.get']);
        Permission::create(['name' => 'invoice.printFiscal']);
        Permission::create(['name' => 'invoice.reportX']);
        Permission::create(['name' => 'invoice.reportZ']);

        Permission::create(['name' => 'invoice.cancel']);


        Permission::create(['name' => 'product.index']);
        Permission::create(['name' => 'product.create']);
        Permission::create(['name' => 'product.delete']);
        Permission::create(['name' => 'product.updated']);
        Permission::create(['name' => 'product.getPaginate']);
        Permission::create(['name' => 'product.get']);

        Permission::create(['name' => 'repair.index']);
        Permission::create(['name' => 'repair.create']);
        Permission::create(['name' => 'repair.delete']);
        Permission::create(['name' => 'repair.updated']);
        Permission::create(['name' => 'repair.getPaginate']);
        Permission::create(['name' => 'repair.get']);

        Permission::create(['name' => 'configuration.upsert']);
        Permission::create(['name' => 'configuration.getPaginate']);
        Permission::create(['name' => 'configuration.index']);
    }
}
