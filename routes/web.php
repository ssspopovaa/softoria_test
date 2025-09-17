<?php

use App\Http\Controllers\SubUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('sub-users.index');
});

Route::prefix('sub-users')->name('sub-users.')->group(function () {
    Route::get('/', [SubUserController::class, 'index'])->name('index');
    Route::get('/create', [SubUserController::class, 'create'])->name('create');
    Route::post('/', [SubUserController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [SubUserController::class, 'edit'])->name('edit');
    Route::post('/update', [SubUserController::class, 'update'])->name('update');
    Route::post('/delete', [SubUserController::class, 'destroy'])->name('destroy');
    Route::get('/{id}/stat', [SubUserController::class, 'stat'])->name('stat');
    Route::post('/pay', [SubUserController::class, 'pay'])
        ->name('pay');
});
