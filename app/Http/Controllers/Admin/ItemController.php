<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ItemsExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\View\View;

class ItemController extends Controller
{
    public function index(): View
    {
        $items = Item::query()
            ->with('category')
            ->withSum('activeLendingLines', 'quantity')
            ->orderBy('name')
            ->get();

        return view('admin.items.index', compact('items'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.items.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('items', 'name')],
            'category_id' => ['required', 'exists:categories,id'],
            'total' => ['required', 'integer', 'min:0'],
            'repair' => ['required', 'integer', 'min:0'],
        ]);

        if ($validated['repair'] > $validated['total']) {
            return back()->withInput()->withErrors(['repair' => 'Jumlah repair tidak boleh melebihi total.']);
        }

        Item::create($validated);

        return redirect()->route('admin.items')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Item $item): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('items', 'name')->ignore($item->id)],
            'category_id' => ['required', 'exists:categories,id'],
            'total' => ['required', 'integer', 'min:0'],
            'new_broke_item' => ['nullable', 'integer', 'min:0'],
        ]);

        $newBroke = (int) ($validated['new_broke_item'] ?? 0);
        unset($validated['new_broke_item']);

        $repair = (int) $item->repair + $newBroke;
        $validated['repair'] = $repair;

        if ($validated['total'] < $repair) {
            return back()->withInput()->withErrors(['total' => 'Total harus mencukupi jumlah repair.']);
        }

        $lent = (int) $item->activeLendingLines()->sum('quantity');
        if ($validated['total'] - $repair < $lent) {
            return back()->withInput()->withErrors(['total' => 'Total dikurangi repair harus tidak kurang dari jumlah yang sedang dipinjam ('.$lent.').']);
        }

        $item->update($validated);

        return redirect()->route('admin.items')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Item $item): RedirectResponse
    {
        if ($item->activeLendingLines()->exists()) {
            return redirect()->route('admin.items')->with('error', 'Barang masih dalam peminjaman aktif, tidak dapat dihapus.');
        }

        $item->delete();

        return redirect()->route('admin.items')->with('success', 'Barang berhasil dihapus.');
    }

    public function export(): BinaryFileResponse
    {
        $name = 'laporan-barang-'.now()->format('Y-m-d_His').'.xlsx';

        return Excel::download(new ItemsExport, $name);
    }
}
