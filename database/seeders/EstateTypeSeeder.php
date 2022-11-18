<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EstateTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ed = \App\Models\EstateType::create([
            'name' => 'Edificio',
            'description' => 'Edificio'
        ]);

        $cab = \App\Models\EstateType::create([
            'name' => 'Cabaña',
            'description' => 'Cabaña'
        ]);

        $roles = \App\Models\Role::all();

        foreach ($roles as $role) {
            if ($role->name == 'Recepcionista Cabaña') {
                $role->estateTypes()->sync([$cab->id]);
            } else
            if ($role->name == 'Recepcionista Edificio') {
                $role->estateTypes()->sync([$ed->id]);
            } else
                if (
                $role->name == 'Supervisor'
                || $role->name == 'Camarero'
                || $role->name == 'Fuera de Servicio'
                || $role->name == 'Usuario'
            ) {
                $role->estateTypes()->sync([
                    $cab->id,
                    $ed->id
                ]);
            }
        }
    }
}
