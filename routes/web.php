<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\TransactionController;
use App\Models\Trade;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return redirect(\route('register'));
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    $details =Trade::query()->where('user_id',$user->id)->get()->sortByDesc('id');
    $trans =Transaction::query()->where('user_id',$user->id)->get()->sortByDesc('id');
    return view('dashboard', compact('user','details','trans'));
})->middleware(['auth', 'verified'])->name('dashboard');

/**
 * Payment Route
 */
Route::post('/payment/callback', [PaymentController::class, 'callback'])
    ->name('callback');
Route::get('/get/data', [PaymentController::class, 'getData']);
Route::post('/trade',[TradeController::class, 'trade'])->name('trade');
Route::post('/destory/{id}',[TradeController::class, 'destroy'])->name('destory');
Route::post('/delete/{id}',[TransactionController::class, 'destroy'])->name('delete');

Route::get('test', function() {
//    $model = User::query();
//    dd(Datatables::eloquent(User::query())->make(true));
    $user = Auth::user();
//    dd($user);

//    return view('dashboard', compact('details'));
});

require __DIR__.'/auth.php';
