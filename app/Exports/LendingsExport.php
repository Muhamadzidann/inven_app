<?php

namespace App\Exports;

use App\Models\Lending;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LendingsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Lending::query()
            ->with(['user', 'lendingItems.item'])
            ->orderByDesc('id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Peminjam',
            'Barang',
            'Qty',
            'Tanggal Pinjam',
            'Tanggal Kembali',
            'Operator',
        ];
    }

    public function map($lending): array
    {
        $lines = $lending->lendingItems->map(fn ($li) => $li->item->name.' ('.$li->quantity.')')->implode('; ');

        return [
            $lending->id,
            $lending->borrower_name,
            $lines,
            $lending->lendingItems->sum('quantity'),
            $lending->created_at?->locale('id')->translatedFormat('j F Y H:i') ?? '',
            $lending->returned_at
                ? $lending->returned_at->locale('id')->translatedFormat('j F Y H:i')
                : '-',
            $lending->user->name,
        ];
    }
}
