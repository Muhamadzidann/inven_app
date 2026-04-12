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
        User::create([
            'name' => 'Admin Wikrama',
            'email' => 'admin@wikrama.sch.id',
            'password' => Hash::make("10"),
            'role' => 'admin',
        ]);

           User::create([
            'name' => 'staff Wikrama',
            'email' => 'staff@wikrama.sch.id',
            'password' => Hash::make("7"),
            'role' => 'staff',
        ]);
    }
}
