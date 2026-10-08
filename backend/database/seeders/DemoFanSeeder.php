<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * A verified fan account for trying the fan app.
 */
class DemoFanSeeder extends Seeder
{
    public function run(): void
    {
        $fan = User::create([
            'full_name' => 'سامي خوري',
            'phone' => '+96170123456',
            'email' => 'fan@madraj.example',
            'password' => 'password',
        ]);
        $fan->forceFill(['phone_verified_at' => now()])->save();

        $fan->notificationSettings()->create();
    }
}
