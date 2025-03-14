<?php


use App\Models\City;
use App\Services\CitiesService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CitiesController;
use App\Http\Controllers\Publical\CartController;
use App\Http\Controllers\Publical\PageController;
use App\Http\Controllers\Publical\CatalogController;
use App\Http\Controllers\Publical\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::post('/cities/set/{city_id}', [CitiesController::class, 'setCity'])->name('cities.set');
Route::post('/cities/{name}', [CitiesController::class, 'filter'])->name('cities.filter');
Route::post('cities/',fn () => response()->json(['data' => City::active()->get()]))->name('cities.all');


Route::post('search', [CatalogController::class, 'searchFast'])->name('search.get');


Route::group(
    ['prefix' => '/cart', 'as' => 'cart.'],
    function () {
        Route::put('/clear', [CartController::class, 'clear'])->name('clear');
        Route::put('/{price}', [CartController::class, 'put'])->name('put');
        Route::put('/{id}/additional', [CartController::class, 'putAdditional'])->name('putAdditional');
        Route::put('/{price}/plus', [CartController::class, 'plus'])->name('plus');
        Route::put('/{price}/minus', [CartController::class, 'minus'])->name('minus');
        Route::put('/{price}/remove', [CartController::class, 'remove'])->name('remove');
    }
);

Route::group(
    ['prefix' => '/order', 'as' => 'order.'],
    function () {
        Route::post('/deliveryRadius', [OrderController::class, 'deliveryRadius'])->name('deliveryRadius');
    }
);


Route::middleware('logs')->get('/info', function (Request $request) {
    $version = DB::select( DB::raw("select version()"));

    return [
        'versions' => [
            'laravel' => App::VERSION(),
            'php' => phpversion(),
            'db' => $version,
        ]
    ];
});
