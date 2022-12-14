<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;

Route::middleware('auth')->group(function () {
    // Account
    Route::get('account', [UserController::class, 'index'])
        ->name('user.account.index');

    Route::patch('account/update', [UserController::class, 'update'])
        ->name('user.update');

    // Addresses
    Route::get('address', [AddressController::class, 'index'])
        ->name('user.address.index');

    Route::patch('address/update/{address}', [AddressController::class, 'update'])
        ->name('address.update');

    Route::post('address/store', [AddressController::class, 'store'])
        ->name('address.store');

    Route::delete('address/{address}', [AddressController::class, 'delete'])
        ->name('address.delete');

    // Orders
    Route::get('orders', [OrderController::class, 'index'])
        ->name('order.index');
    Route::get('order/{order}', [OrderController::class, 'show'])
        ->name('order.show');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])
        ->name('wishlist.index');
    Route::delete('/wishlist/{wishlistItem}', [WishlistController::class, 'destroy'])
        ->name('wishlist.destroy');
    Route::post('/wishlist/store', [WishlistController::class, 'store'])
        ->name('wishlist.store');
});