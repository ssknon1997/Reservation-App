<?php

use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('shops.index');
});


Route::middleware(['auth'])->group(function () {

    Route::middleware(['owner'])->group(function () {
        Route::resource('shops', ShopController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy']);
    });
    
});

Route::resource('shops', ShopController::class)
    ->only(['index', 'show']);

require __DIR__.'/auth.php';
