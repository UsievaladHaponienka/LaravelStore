<?php

use App\Http\Controllers\CartController;

Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
