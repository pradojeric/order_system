<?php

use App\Models\Dish;
use App\Models\Order;
use App\Http\Livewire\Order\Details;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DishController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\WaiterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConfigurationController;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/print/{order}/{reprint?}', [OrderController::class, 'printReceipt']);
Route::get('/print-po/{order}', [OrderController::class, 'printPurchasOrder']);

Route::get('/test', function () {
    $pdf = App::make('dompdf.wrapper');
    $pdf->loadHTML('<h1>Test</h1>');
    return $pdf->stream();

});


Route::middleware('guest')->post('/login-passcode', [WaiterController::class, 'loginViaPasscode']);


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/users/edit-profile', [UserController::class, 'editProfile'])->name('edit-profile');
    Route::get('/waiter-order', [WaiterController::class, 'waiterOrder']);
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/waiter-dashboard', [waiterController::class, 'dashboard'])->name('waiter.dashboard');

    Route::get('/orders/create/{action}/{tableId?}', [OrderController::class, 'create'])->name('orders.create');
    Route::get('/orders/show/{action}/{order}/{tableId?}', [OrderController::class, 'show'])->name('orders.show');
    // Route::get('/orders/create/{action?}/{tableId?}', Details::class)->name('orders.create');

    Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('/users/restore/{user}', [UserController::class, 'activate'])->name('users.restore');
        Route::post('/user/assign/{user}', [UserController::class, 'assignTable'])->name('users.assign.table');
        Route::resource('users', UserController::class);

        Route::resource('tables', TableController::class);

        Route::resource('menus', CategoryController::class);

        Route::get('/reports', [ReportController::class, 'index']);
        Route::get('/config', [ConfigurationController::class, 'index']);
        Route::put('/order-number-update', [ConfigurationController::class, 'editOrderNo']);
        Route::put('/receipt-number-update', [ConfigurationController::class, 'editReceiptNo']);
        Route::put('/tin-number-update', [ConfigurationController::class, 'editTinNo']);
        Route::put('/tip-update', [ConfigurationController::class, 'editTip']);

        Route::delete('/dishes/deactivate/{dish}', [DishController::class, 'deactivate'])->name('dishes.deactivate');
        Route::get('/dishes/restore/{dish}', [DishController::class, 'restore'])->name('dishes.restore');
        Route::resource('dishes', DishController::class);
    });
});


require __DIR__ . '/auth.php';
