<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    return Inertia::render('Customers');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/customers/create', function () {
    return Inertia::render('CustomersCreate');
})->middleware(['auth', 'verified'])->name('customers.create');
Route::get('/customers/{id}/edit', function () {
    return Inertia::render('CustomersEdit');
})->middleware(['auth', 'verified'])->name('customers.edit');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
