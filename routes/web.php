<?php

use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\OwnerReservationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('shops.index');
});


Route::middleware(['auth'])->group(function () {

    Route::middleware(['owner'])->group(function () {
        Route::resource('shops', ShopController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy']);

        Route::get('owner/reservations', [OwnerReservationController::class, 'index'])
            ->name('owner.reservations.index');
        Route::get('owner/reservations/{reservation}', [OwnerReservationController::class, 'show'])
            ->name('owner.reservations.show');

        Route::patch('owner/reservations/{reservation}/confirm', [OwnerReservationController::class, 'confirm'])
        ->name('owner.reservations.confirm');
    });

    Route::resource('reservations', ReservationController::class);

    Route::patch('reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])
        ->name('reservations.cancel');

});

Route::resource('shops', ShopController::class)
    ->only(['index', 'show']);


Route::get('/dashboard', function () {
    return redirect()->route('shops.index');
})->middleware(['auth'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
