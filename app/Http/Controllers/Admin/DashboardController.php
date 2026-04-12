<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\Lending;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'totalCategories' => Category::count(),
            'totalItems' => Item::count(),
            'totalUsers' => User::count(),
            'totalLendings' => Lending::count(),
        ]);
    }
}
