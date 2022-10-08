<?php

namespace Database\Seeders;

use App\Models\RoomStatus;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            //------------
            DayWeekSeeder::class,
            PartialRateSeeder::class,
            RoomStatuseSeeder::class,
            RoomTypeSeeder::class,
            ShiftSystemSeeder::class,
            ShiftTimeSeeder::class,
            ThemeTypeSeeder::class
        ]);
    }
}
