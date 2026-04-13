<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =======================
        // USER SEEDER
        // =======================
        User::updateOrCreate([
            'email' => 'admin@smkwikrama.sch.id',
        ], [
            'name' => 'Administrator',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'password_is_default' => true,
        ]);

        User::updateOrCreate([
            'email' => 'operator@smkwikrama.sch.id',
        ], [
            'name' => 'Operator',
            'password' => Hash::make('operator'),
            'role' => 'operator',
            'password_is_default' => true,
        ]);

        User::updateOrCreate([
            'email' => 'staff@smkwikrama.sch.id',
        ], [
            'name' => 'Staff',
            'password' => Hash::make('staff'),
            'role' => 'staff',
            'password_is_default' => true,
        ]);

        // =======================
        // CATEGORY SEEDER (AMAN)
        // =======================
        $cat = Category::updateOrCreate(
            ['name' => 'Elektronik'],
            ['division_pj' => 'Sarpras']
        );

        $cat2 = Category::updateOrCreate(
            ['name' => 'Alat Dapur'],
            ['division_pj' => 'Sarpras']
        );

        // =======================
        // ITEM SEEDER (AMAN)
        // =======================
        Item::updateOrCreate(
            ['name' => 'Kompor Gas'],
            [
                'category_id' => $cat2->id,
                'total' => 3,
                'repair' => 0,
            ]
        );

        Item::updateOrCreate(
            ['name' => 'Panci Stainless'],
            [
                'category_id' => $cat2->id,
                'total' => 7,
                'repair' => 1,
            ]
        );

        Item::updateOrCreate(
            ['name' => 'Proyektor Epson'],
            [
                'category_id' => $cat->id,
                'total' => 10,
                'repair' => 1,
            ]
        );

        Item::updateOrCreate(
            ['name' => 'Speaker Portable'],
            [
                'category_id' => $cat->id,
                'total' => 5,
                'repair' => 0,
            ]
        );
    }
}