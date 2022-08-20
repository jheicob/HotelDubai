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
        $Admin= Role::create([
            'name' => 'Admin', 
        ]);

        $user = User::find(1);
        $user->assignRole('Admin');
        $Admin->givePermissionTo([
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
            'users.getPaginate'   
        ]);
    }
}
