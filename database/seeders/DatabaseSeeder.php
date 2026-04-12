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
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@smkwikrama.sch.id',
            'password' => Hash::make('temp-seed-placeholder'),
            'role' => 'admin',
            'password_is_default' => true,
        ]);
        $admin->password = User::defaultPasswordPlain($admin);
        $admin->save();

        $operator = User::create([
            'name' => 'Operator',
            'email' => 'operator@smkwikrama.sch.id',
            'password' => Hash::make('temp-seed-placeholder'),
            'role' => 'operator',
            'password_is_default' => true,
        ]);
        $operator->password = User::defaultPasswordPlain($operator);
        $operator->save();

        $cat = Category::create([
            'name' => 'Elektronik',
            'division_pj' => 'Sarpras',
        ]);

        Item::create([
            'category_id' => $cat->id,
            'name' => 'Proyektor Epson',
            'total' => 10,
            'repair' => 1,
        ]);

        Item::create([
            'category_id' => $cat->id,
            'name' => 'Speaker Portable',
            'total' => 5,
            'repair' => 0,
        ]);
    }
}
