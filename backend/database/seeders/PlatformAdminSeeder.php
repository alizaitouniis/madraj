<?php

namespace Database\Seeders;

use App\Models\PlatformAdmin;
use Illuminate\Database\Seeder;

class PlatformAdminSeeder extends Seeder
{
    public function run(): void
    {
        PlatformAdmin::create([
            'name' => 'مالك المنصة',
            'email' => 'admin@madraj.example',
            'password' => 'password',
        ]);
    }
}
