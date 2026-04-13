<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@wikrama.sch.id'],
            [
                'name' => 'Admin Wikrama',
                'password' => Hash::make("admin"),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff@wikrama.sch.id'],
            [
                'name' => 'staff Wikrama',
                'password' => Hash::make("staff"),
                'role' => 'staff',
            ]
        );
    }
}
