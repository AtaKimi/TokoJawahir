<?php

use Illuminate\Support\Facades\Route;

Route::controller(App\Http\Controllers\Guest\Homepage::class)->group(function () {
    Route::get('/', 'index')->name('guest.index');
});

Route::prefix('jewellery')->group(function () {
    Route::controller(App\Http\Controllers\Guest\JewelleryController::class)->group(function () {
        Route::get('/', 'index')->name('guest.jewellery.index');
        Route::get('/{jewellery}', 'show')->name('guest.jewellery.show');
    });
});

Route::middleware('auth')->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::prefix('admin')->group(function () {
            Route::controller(App\Http\Controllers\Admin\Dashboard::class)->group(function () {
                Route::get('/', 'index')->name('admin.dashboard');
            });
            Route::prefix('jewellery')->group(function () {
                Route::controller(App\Http\Controllers\Admin\JewelleryController::class)->group(function () {
                    Route::get('/', 'index')->name('admin.jewellery.index');
                    Route::get('/create', 'create')->name('admin.jewellery.create');
                    Route::get('/{jewellery}/edit', 'edit')->name('admin.jewellery.edit');
                    Route::put('/{jewellery}', 'update')->name('admin.jewellery.update');
                    Route::post('/', 'store')->name('admin.jewellery.store');
                    Route::delete('/{jewellery}', 'destroy')->name('admin.jewellery.destroy');
                });
            });

            Route::prefix('transaction')->group(function () {
                Route::controller(App\Http\Controllers\Admin\TransactionController::class)->group(function () {
                    Route::get('/', 'index')->name('admin.transaction.index');
                    Route::get('/users/', 'users')->name('admin.transaction.users');
                    Route::get('/{user}/create', 'create')->name('admin.transaction.create');
                    Route::get('/{user}/{transaction}/review', 'review')->name('admin.transaction.review');
                    Route::put('/{user}/{transaction}/review', 'confirmation')->name('admin.transaction.confirmation');
                });
            });

            Route::prefix('buyback')->group(function () {
                Route::controller(App\Http\Controllers\Admin\BuyBackController::class)->group(function () {
                    Route::get('/', 'index')->name('admin.buyback.index');
                    Route::get('users/', 'users')->name('admin.buyback.users');
                    Route::get('{user}/create', 'create')->name('admin.buyback.create');
                    Route::get('{user}/beli-kembali/{buy_back}/review', 'review')->name('admin.buyback.review');
                    Route::put('{user}/beli-kembali/{buy_back}/review', 'confirmation')->name('admin.buyback.confirmation');
                });
            });

            Route::prefix('user')->group(function () {
                Route::controller(App\Http\Controllers\Admin\UserController::class)->group(function () {
                    Route::get('/', 'index')->name('admin.user.index');
                    Route::get('/{user}/transactions', 'transactions')->name('admin.user.transactions');
                    Route::get('/{user}/buybacks', 'buyBacks')->name('admin.user.buybacks');
                });
            });
            Route::prefix('store')->group(function () {
                Route::controller(App\Http\Controllers\Admin\StoreController::class)->group(function () {
                    Route::get('/', 'index')->name('admin.store.index');
                    Route::get('/edit', 'edit')->name('admin.store.edit');
                    Route::put('/', 'update')->name('admin.store.update');
                    Route::put('/buyback-percentage', 'updateBuyBackPercentage')->name('admin.store.update-buyback-percentage');
                    Route::post('/', 'store')->name('admin.store.store');
                });
            });
        });
    });

    Route::prefix('user')->group(function () {
        Route::prefix('profile')->group(function () {
            Route::controller(App\Http\Controllers\User\ProfileController::class)->group(function () {
                Route::get('/', 'index')->name('user.profile.index');
                Route::get('/edit', 'edit')->name('user.profile.edit');
                Route::put('/photo', 'updatePhoto')->name('user.profile.update-photo');
                Route::put('/', 'update')->name('user.profile.update');
            });
        });

        Route::prefix('buyback')->group(function () {
            Route::controller(App\Http\Controllers\User\BuyBackController::class)->group(function () {
                Route::get('/', 'index')->name('user.buyback.index');
                Route::get('/{buy_back}', 'show')->name('user.buyback.show');
            });
        });
        Route::prefix('transaction')->group(function () {
            Route::controller(App\Http\Controllers\User\TransactionController::class)->group(function () {
                Route::get('/', 'index')->name('user.transaction.index');
                Route::get('/{transaction}', 'show')->name('user.transaction.show');
            });
        });
    });
});
