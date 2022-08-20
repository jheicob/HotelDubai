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
            ]
        );
    }
}
