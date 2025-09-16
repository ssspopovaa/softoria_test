<?php

use App\Http\Controllers\SubUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('sub-users.index');
});

Route::get('sub-users', [SubUserController::class, 'index'])->name('sub-users.index');
Route::get('sub-users/create', [SubUserController::class, 'create'])->name('sub-users.create');
Route::post('sub-users', [SubUserController::class, 'store'])->name('sub-users.store');
Route::get('sub-users/{id}/edit', [SubUserController::class, 'edit'])->name('sub-users.edit');
Route::post('sub-users/update', [SubUserController::class, 'update'])->name('sub-users.update');
Route::post('sub-users/delete', [SubUserController::class, 'destroy'])->name('sub-users.destroy');
Route::get('sub-users/{id}/stat', [SubUserController::class, 'stat'])->name('sub-users.stat');

Route::post('sub-users/simulate-payment', [SubUserController::class, 'simulatePayment'])
    ->name('sub-users.simulatePayment');
