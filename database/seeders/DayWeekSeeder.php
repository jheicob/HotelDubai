<?php

namespace Database\Seeders;

use App\Models\DayWeek;
use Illuminate\Database\Seeder;

class DayWeekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DayWeek::upsert([
            [
                'name'        => 'Lunes',
                'description' => 'Lunes'
            ],
            [
                'name'        => 'Martes',
                'description' => 'Martes'
            ],
            [
                'name'        => 'Miércoles',
                'description' => 'Miércoles'
            ],
            [
                'name'        => 'Jueves',
                'description' => 'Jueves'
            ],
            [
                'name'        => 'Viernes',
                'description' => 'Viernes'
            ],
            [
                'name'        => 'Sábado',
                'description' => 'Sábado'
            ],
            [
                'name'        => 'Domingo',
                'description' => 'Domingo'
            ],
        ],['name'],['description']);
    }
}
