<?php

namespace Database\Seeders;

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
            ConfigurationSeeder::class,
            DayWeekSeeder::class,
            PartialRateSeeder::class,
            RoomStatuseSeeder::class,
            RoomTypeSeeder::class,
            PartialCostSeeder::class,
            ShiftSystemSeeder::class,
            ShiftTimeSeeder::class,
            ThemeTypeSeeder::class,
            TypeDocumentSeeder::class,
            EstateTypeSeeder::class,
            RoomSeeder::class,
        ]);
    }
}
