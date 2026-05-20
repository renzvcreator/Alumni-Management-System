<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@alumni.test'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'approved',
                'email_verified_at' => now(),
            ]
        );

        Profile::updateOrCreate(
            ['user_id' => $admin->id],
            [
                'first_name' => 'System',
                'last_name' => 'Administrator',
            ]
        );

        $approved = User::updateOrCreate(
            ['email' => 'alumni@alumni.test'],
            [
                'name' => 'Demo Alumni',
                'password' => Hash::make('password'),
                'role' => 'alumni',
                'status' => 'approved',
                'email_verified_at' => now(),
            ]
        );

        Profile::updateOrCreate(
            ['user_id' => $approved->id],
            [
                'first_name' => 'Demo',
                'last_name' => 'Alumni',
                'graduation_year' => 2020,
                'current_job' => 'Software Engineer',
                'industry' => 'Technology',
                'contact_number' => '09171234567',
                'bio' => 'Sample approved alumni account for demonstration.',
            ]
        );
    }
}
