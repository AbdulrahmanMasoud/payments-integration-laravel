<?php

use App\Http\Controllers\Paymob\PaymobController;
use App\Http\Controllers\Paypal\PaypalController;
use App\Http\Controllers\Stripe\StripeController;
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
    return view('welcome');
});
 Route::post('/',[PaypalController::class,'__construct'])->name('paypal.checkout');
 Route::get('paypal/checkout/cancel',[PaypalController::class,'canceled'])->name('paypal.cancel');
 Route::get('paypal/checkout/return',[PaypalController::class,'returned'])->name('paypal.return');
// 
 Route::post('/stripe-payment', [StripeController::class, 'handlePost'])->name('stripe.payment');


//  
Route::get('/paymob',[PaymobController::class,'index']);
Route::post('/paymob/checkout',[PaymobController::class,'authPaymob'])->name('paymob.checkout');
Route::get('/paymob/mkorder/token={token}/merchant_id={id}',[PaymobController::class,'makeOrderPaymob'])->name('mk.order');
Route::get('/paymob/mkorder/token={token}/orderid={id}',[PaymobController::class,'getPaymentKeyPaymob'])->name('get.payment.key');