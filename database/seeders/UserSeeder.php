<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
   public function run(): void
    {
        $passwordExpiryDays = config('auth.password_expiry_days', 90);

       Admin::create([
    'name' => 'Admin User', // required!
    'email' => 'admin@example.com',
    'password' => Hash::make('Admin@123456'), // change before production
    'role' => 'admin',
    'password_changed_at' => now(),
    'password_expires_at' => now()->addDays($passwordExpiryDays),
    'password_version' => 1,
    'is_active' => true,
]);

Admin::create([
    'name' => 'Super Admin', // required!
    'email' => 'superadmin@example.com',
    'password' => Hash::make('SuperAdmin@123456'), // change before production
    'role' => 'super_admin',
    'password_changed_at' => now(),
    'password_expires_at' => now()->addDays($passwordExpiryDays),
    'password_version' => 1,
    'is_active' => true,
]);
    }
}
