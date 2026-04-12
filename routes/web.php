<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ItemController as AdminItemController;
use App\Http\Controllers\Admin\LendingReadController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\Operator\ItemController as OperatorItemController;
use App\Http\Controllers\Operator\LendingController as OperatorLendingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest')->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/items', [AdminItemController::class, 'index'])->name('items');
    Route::get('/items/create', [AdminItemController::class, 'create'])->name('items.create');
    Route::post('/items', [AdminItemController::class, 'store'])->name('items.store');
    Route::get('/items/{item}/edit', [AdminItemController::class, 'edit'])->name('items.edit');
    Route::put('/items/{item}', [AdminItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{item}', [AdminItemController::class, 'destroy'])->name('items.destroy');
    Route::get('/items-export', [AdminItemController::class, 'export'])->name('items.export');

    Route::get('/lendings', [LendingReadController::class, 'index'])->name('lendings.index');
    Route::get('/lendings/{lending}', [LendingReadController::class, 'show'])->name('lendings.show');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.reset-password');
    Route::get('/users-export', [AdminUserController::class, 'export'])->name('users.export');
});

Route::middleware(['auth', 'operator'])->prefix('operator')->name('operator.')->group(function () {
    Route::get('/dashboard', OperatorDashboardController::class)->name('dashboard');
    Route::get('/lendings', [OperatorLendingController::class, 'index'])->name('lendings');
    Route::get('/lendings/create', [OperatorLendingController::class, 'create'])->name('lendings.create');
    Route::post('/lendings', [OperatorLendingController::class, 'store'])->name('lendings.store');
    Route::get('/lendings-export', [OperatorLendingController::class, 'export'])->name('lendings.export');
    Route::get('/lendings/{lending}', [OperatorLendingController::class, 'show'])->name('lendings.show');
    Route::post('/lendings/{lending}/return', [OperatorLendingController::class, 'returnLending'])->name('lendings.return');
    Route::delete('/lendings/{lending}', [OperatorLendingController::class, 'destroy'])->name('lendings.destroy');

    Route::get('/items', [OperatorItemController::class, 'index'])->name('items');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
