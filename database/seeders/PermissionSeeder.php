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

        

        
    }
}
