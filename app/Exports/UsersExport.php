<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return User::query()->orderBy('id')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Email',
            'Peran',
            'Password (default)',
        ];
    }

    public function map($user): array
    {
        $plain = '';
        if ($user->password_is_default) {
            $plain = User::defaultPasswordPlain($user);
        }

        return [
            $user->id,
            $user->name,
            $user->email,
            $user->role === 'staff' ? 'operator' : $user->role,
            $plain,
        ];
    }
}
