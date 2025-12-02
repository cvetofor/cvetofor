<?php

use App\Http\Controllers\Twill\BalanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Twill\ColorController;
use App\Http\Controllers\Twill\OrderController;
use App\Http\Controllers\Twill\MarketController;
use App\Http\Controllers\Twill\ProductController;
use App\Http\Controllers\Twill\GroupProductController;

Route::get('/', 'App\Http\Controllers\Twill\OrderController@index')->name('dashboard');

Route::get('/history/f/{groupProduct}', [GroupProductController::class, 'history'])->name('history.groupProduct.price');
Route::get('/history/p/{product}', [ProductController::class, 'history'])->name('history.product.price');

// переопределить поиск
Route::name('search')->get('/search', [\App\Http\Controllers\Twill\DashboardController::class, 'search']);



TwillRoutes::module('orders');
Route::post('/orders/{order}/status/', [OrderController::class, 'changeOrderStatus'])->name('orders.status');


// TwillRoutes::module('remains');

TwillRoutes::module('products');

Route::get('/products/{category}/list', [ProductController::class, 'list'])->name('products.list')->whereNumber('category');

Route::put('/products/prices/change', [ProductController::class, 'changePrice'])->name('products.changePrice');

Route::get('/products/prices/export', [ProductController::class, 'export'])->name('products.export');
Route::post('/products/prices/import', [ProductController::class, 'import'])->name('products.import');


TwillRoutes::module('groupProducts');

// Акции пока не доступны
# TwillRoutes::module('stocks');

TwillRoutes::module('categories');

# TwillRoutes::module('attributes');

Route::name('stats.')->group(function () {
    Route::get('/stats', [\App\Http\Controllers\Twill\StatController::class, 'index'])->name('index');
});

TwillRoutes::module('markets');
Route::post('/markets/auth/{marketId}', [MarketController::class, 'authBy'])->name('markets.auth');
Route::post('/markets/delete/{marketId}', [MarketController::class, 'delete'])->name('markets.delete');
Route::group(['prefix' => 'markets'], function () {
    Route::post('intervals/bulk-update', [MarketController::class, 'bulkUpdateIntervals'])->name('markets.intervals.bulk-update');
    Route::post('{market}/intervals', [MarketController::class, 'storeInterval'])->name('markets.intervals.store');
    Route::delete('intervals/{interval}', [MarketController::class, 'deleteInterval'])->name('markets.intervals.delete');
});


#TwillRoutes::module('paymentDetails');
TwillRoutes::module('marketWorkTimes');



Route::group(['prefix' => 'areas'], function () {
    Route::get('import', [\App\Http\Controllers\Twill\RegionController::class, 'import'])->name('areas.import');
    Route::post('import', [\App\Http\Controllers\Twill\RegionController::class, 'runImport'])->name('areas.run.import');
});
Route::get('/help', fn() => view('twill.admin.help'))->name('help');


TwillRoutes::module('regions');
TwillRoutes::module('cities');
TwillRoutes::module('payments');
TwillRoutes::module('pages');
TwillRoutes::module('hollydays');
TwillRoutes::module('deliveries');
TwillRoutes::module('balances');
Route::get('/r/b/', [BalanceController::class, 'recalc'])->name('balances.recalc');

TwillRoutes::module('paymentStatuses');
TwillRoutes::module('deliveryStatuses');
TwillRoutes::module('orderStatuses');
TwillRoutes::module('profiles');

TwillRoutes::module('colors');
Route::get('color/{color}/edit', [ColorController::class, 'edit'])->name('color.edit');

TwillRoutes::module('groupProductCategories');
TwillRoutes::module('reviews');

TwillRoutes::module('legalAccounts');

TwillRoutes::module('forms');

TwillRoutes::module('tags');
TwillRoutes::module('seotags');
TwillRoutes::module('promocods');
TwillRoutes::module('menuPrices');
TwillRoutes::module('menuFlovers');
