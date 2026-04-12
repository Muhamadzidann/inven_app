<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Lending;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LendingReadController extends Controller
{
    public function index(Request $request): View
    {
        $query = Lending::query()
            ->with(['user', 'lendingItems.item'])
            ->orderByDesc('id');

        if ($request->filled('item')) {
            $itemId = (int) $request->query('item');
            $query->whereHas('lendingItems', fn ($q) => $q->where('item_id', $itemId));
        }

        $lendings = $query->paginate(15)->withQueryString();
        $filterItem = $request->filled('item') ? Item::find($request->query('item')) : null;

        return view('admin.lendings.index', compact('lendings', 'filterItem'));
    }

    public function show(Lending $lending): View
    {
        $lending->load(['user', 'lendingItems.item']);

        return view('admin.lendings.show', compact('lending'));
    }
}
