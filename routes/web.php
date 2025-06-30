<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\Publical\CartController;
use App\Http\Controllers\Publical\PageController;
use App\Http\Controllers\Publical\OrderController;
use App\Http\Controllers\Publical\SearchController;
use App\Http\Controllers\Publical\CatalogController;
use App\Http\Controllers\Publical\ProfileController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Publical\Payments\RobokassaController;
use App\Http\Controllers\Publical\Payments\YookassaController;

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

Route::group(
    ['prefix' => '/payments/gateway', 'as' => 'payments.gateway.'],
    function () {

        Route::group(
            ['prefix' => '/robokassa', 'as' => 'robokassa.'],
            function () {
                Route::any('/success', [RobokassaController::class, 'success'])->name('success');
                Route::any('/fail', [RobokassaController::class, 'fail'])->name('fail');
            }
        );

        Route::group(
            ['prefix' => '/yookassa', 'as' => 'yookassa.'],
            function () {
                Route::any('/return', [YookassaController::class, 'redirect'])->name('return');
                Route::post('/callback', [YookassaController::class, 'callback']);
            }
        );
    }
);


Route::get('/', [CatalogController::class, 'welcome'])->name('welcome');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


/**
 * Каталог
 */
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');

Route::get('/catalog/tags/{tag}', [CatalogController::class, 'tags'])->name('catalog.tags');


Route::get('catalog/{slug}/{price}', [CatalogController::class, 'product'])->where('slug', '.*')->name('catalog.product');
Route::get('catalog/{slug}', [CatalogController::class, 'category'])->where('slug', '.*')->name('catalog.category');


Route::group(
    ['prefix' => '/cart', 'as' => 'cart.'],
    function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
    }
);

Route::group(
    ['prefix' => '/order', 'as' => 'order.'],
    function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/pay/{order}', [OrderController::class, 'pay'])->name('pay');
        Route::post('/create', [OrderController::class, 'create'])->name('create')->middleware(['throttle:60,1']);
        Route::get('/{order}', [OrderController::class, 'show'])->name('show')->middleware(['throttle:10,1']);
        Route::get('/{order}/pdf', [OrderController::class, 'pdf'])->name('pdf')->middleware(['throttle:10,1']);
        Route::get('/{order_num}/payment', [OrderController::class, 'paymentShortLink'])->name('paymentShortLink');
    }
);

Route::group(
    ['prefix' => '/profile', 'as' => 'profile.'],
    function () {
        Route::get('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');
        Route::post('/resetPassword', [ResetPasswordController::class, 'resetPassword'])->name('resetPassword');

        Route::get('/orders', [ProfileController::class, 'orders'])->name('orders');
        Route::post('/order/review', [ProfileController::class, 'review'])->name('review');
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::post('/', [ProfileController::class, 'update'])->name('update');
        Route::get('/change/password', [ProfileController::class, 'changePassword'])->name('changePassword');
        Route::get('/change/email', [ProfileController::class, 'changeEmail'])->name('changeEmail');
        Route::post('/change/email', [ProfileController::class, 'changeEmailRequest'])->name('changeEmailRequest');
        Route::get('/change/email/{user}/{email}', [ProfileController::class, 'changeEmailConfirm'])->name('changeEmail.confirm');
    }
);

Route::get('/email/verify', function () {

    if (auth()->user()->email_verified_at != null) {
        return redirect()->route('profile.index');
    }
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request, $id) {
    $request->fulfill();

    $user = User::where(['id' => $id])->first();
    $user->profile->published = true;
    $user->profile->save();

    return redirect('/profile');
})->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Ссылка отправлена!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');



Route::get('/search', [CatalogController::class, 'search'])->name('catalog.search');


Route::post('/form', [FormController::class, 'form'])->name('form')->middleware(['throttle:6,1']);

/**
 * Страницы
 */
Route::get('{slug}', [PageController::class, 'show'])->where('slug', '.*');
