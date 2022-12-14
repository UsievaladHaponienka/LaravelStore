<?php

use App\Http\Controllers\CartController;

Route::get('cart', [CartController::class, 'index'])
    ->name('cart.index');

Route::post('cart/store', [CartController::class, 'store'])
    ->name('cart.store');

Route::delete('cart/{cartItem}', [CartController::class, 'destroy'])
    ->name('cart.destroy');

Route::delete('cart', [CartController::class, 'destroyAll'])
    ->name('cart.destroy.all');

Route::patch('cart/{cartItem}', [CartController::class, 'update'])
    ->name('cart.update');

Route::get('cart/get-items-count', [CartController::class, 'getItemsCount'])
    ->name('cart.get-items-count');