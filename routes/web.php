<?php

use App\Models\Dish;
use App\Models\User;
use App\Models\Order;
use App\Http\Livewire\Order\Details;
use App\Http\Livewire\KitchenPrint;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DishController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\WaiterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConfigurationController;
use App\Events\PrintKitchenEvent;
use App\Models\OrderDetails;

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

Route::get('/test-order/{waiter_id?}', function($waiter_id = null) {
    $orderIds = Order::when($waiter_id, function($q) use ($waiter_id){
        $q->where('waiter_id', $waiter_id);
    })->get()->pluck('id');

    $orderDetails = OrderDetails::whereIn('order_id', $orderIds)
        ->select('dish_id', DB::raw('SUM(order_details.pcs) as pcs'), DB::raw('SUM(order_details.price) as price'))
        ->groupBy('dish_id')
        ->get();

    foreach($orderDetails as $d){
        echo "Dish: ".$d->dish->name."<br>";
        echo $d->pcs."<br>";
        echo $d->price."<br>";
        if($d->isDrink()) echo "is Drink";
        if($d->isFood()) echo "is Food";
        echo "<br><br>";
    }
});


Route::get('/kitchen', KitchenPrint::class);

Route::get('/print/{order}/{reprint?}', [OrderController::class, 'printReceipt']);
Route::get('/print-kitchen/{order}', [OrderController::class, 'printKitchen']);

Route::get('/print-bill/{order}', [OrderController::class, 'printBill']);
Route::get('/print-waiter-report/{waiter}/{startDate}/{endDate?}', [WaiterController::class, 'printWaiterReport']);
Route::get('/print-po/{order}', [OrderController::class, 'printPurchasOrder']);

Route::get('/test', function () {
    $orders = Order::with(['orderDetails', 'customOrderDetails'])
        ->whereDate('created_at', now()->toDateString())
        ->where('waiter_id', 3)
        ->get();
    return ($orders);

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
