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
        $Admin= Role::create(
            [
            'name' => 'Admin',
            ]
        );

        $user = User::find(1);
        $user->assignRole('Admin');
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

            'day.templates.index',
            'day.templates.create',
            'day.templates.delete',
            'day.templates.updated',
            'day.templates.getPaginate',
            'day.templates.get',
            ]
        );
    }
}
