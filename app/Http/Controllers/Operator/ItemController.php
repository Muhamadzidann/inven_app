<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Item;
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

        return view('operator.items.index', compact('items'));
    }
}
