<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Lending;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('operator.dashboard', [
            'activeLendings' => Lending::whereNull('returned_at')->count(),
            'totalItems' => Item::count(),
            'recentLendings' => Lending::with('user')
                ->orderByDesc('id')
                ->limit(5)
                ->get(),
        ]);
    }
}
