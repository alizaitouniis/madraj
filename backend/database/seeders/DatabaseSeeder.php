<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Launch data (stadium, Cedars FC) plus demo accounts. Content follows the Figma frames.
 * Demo accounts use the password "password": do not run on production as is.
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PlatformAdminSeeder::class,
            StadiumSeeder::class,
            CedarsFcSeeder::class,
            DemoFanSeeder::class,
        ]);
    }
}
