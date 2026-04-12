<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ItemsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Item::query()
            ->with('category')
            ->withSum('activeLendingLines', 'quantity')
            ->orderBy('id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Kategori',
            'Total',
            'Repair',
            'Available',
            'Lending Total',
            'Diperbarui',
        ];
    }

    public function map($item): array
    {
        $repair = (int) $item->repair;
        $lent = (int) ($item->active_lending_lines_sum_quantity ?? 0);
        $available = max(0, (int) $item->total - $repair - $lent);

        return [
            $item->id,
            $item->name,
            $item->category->name,
            $item->total,
            $repair === 0 ? '-' : $repair,
            $available,
            $lent,
            $item->updated_at?->locale('id')->translatedFormat('j F Y') ?? '',
        ];
    }
}
