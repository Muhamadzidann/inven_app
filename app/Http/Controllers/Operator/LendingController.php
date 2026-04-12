<?php

namespace App\Http\Controllers\Operator;

use App\Exports\LendingsExport;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Lending;
use App\Models\LendingItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\View\View;

class LendingController extends Controller
{
    public function index(Request $request): View
    {
        $query = Lending::query()
            ->with(['user', 'lendingItems.item'])
            ->orderByDesc('id');

        if ($request->filled('item')) {
            $query->whereHas('lendingItems', fn ($q) => $q->where('item_id', (int) $request->query('item')));
        }

        $lendings = $query->paginate(15)->withQueryString();

        return view('operator.lendings.index', compact('lendings'));
    }

    public function create(): View
    {
        $items = Item::query()
            ->with('category')
            ->withSum('activeLendingLines', 'quantity')
            ->orderBy('name')
            ->get();

        return view('operator.lendings.create', compact('items'));
    }

    public function store(Request $request): RedirectResponse
    {
        $lines = collect($request->input('lines', []))
            ->filter(fn ($l) => ! empty($l['item_id']) && isset($l['quantity']))
            ->values()
            ->all();

        $request->merge(['lines' => $lines]);

        $request->validate([
            'borrower_name' => ['required', 'string', 'max:255'],
            'lines' => ['required', 'array', 'min:1'],
            'lines.*.item_id' => ['required', 'exists:items,id'],
            'lines.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        $byItem = collect($lines)->groupBy('item_id')->map(fn ($g) => $g->sum('quantity'));

        try {
            DB::transaction(function () use ($request, $lines, $byItem) {
                foreach ($byItem as $itemId => $qty) {
                    $item = Item::query()->lockForUpdate()->findOrFail($itemId);
                    $out = (int) LendingItem::query()
                        ->where('item_id', $item->id)
                        ->whereHas('lending', fn ($q) => $q->whereNull('returned_at'))
                        ->sum('quantity');
                    $avail = max(0, (int) $item->total - (int) $item->repair - $out);
                    if ($qty > $avail) {
                        throw ValidationException::withMessages([
                            'lines' => "Stok tidak cukup untuk «{$item->name}». Tersedia: {$avail}, diminta: {$qty}.",
                        ]);
                    }
                }

                $lending = Lending::create([
                    'borrower_name' => $request->borrower_name,
                    'user_id' => $request->user()->id,
                ]);

                foreach ($lines as $line) {
                    LendingItem::create([
                        'lending_id' => $lending->id,
                        'item_id' => $line['item_id'],
                        'quantity' => (int) $line['quantity'],
                    ]);
                }
            });
        } catch (ValidationException $e) {
            return back()->withInput()->withErrors($e->errors());
        }

        return redirect()->route('operator.lendings')->with('success', 'Peminjaman berhasil dicatat.');
    }

    public function show(Lending $lending): View
    {
        $lending->load(['user', 'lendingItems.item']);

        return view('operator.lendings.show', compact('lending'));
    }

    public function returnLending(Lending $lending): RedirectResponse
    {
        if ($lending->returned_at) {
            return redirect()->route('operator.lendings')->with('error', 'Peminjaman sudah dikembalikan.');
        }

        $lending->update(['returned_at' => now()]);

        return redirect()->route('operator.lendings')->with('success', 'Barang ditandai sebagai dikembalikan.');
    }

    public function destroy(Lending $lending): RedirectResponse
    {
        $lending->delete();

        return redirect()->route('operator.lendings')->with('success', 'Data peminjaman dihapus.');
    }

    public function export(): BinaryFileResponse
    {
        $name = 'laporan-peminjaman-'.now()->format('Y-m-d_His').'.xlsx';

        return Excel::download(new LendingsExport, $name);
    }
}
