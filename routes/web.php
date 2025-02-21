<?php

use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\CustomerDetailsController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\NumberDetailsController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\TransactionDetailsController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\JwtAuth;
use App\Http\Middleware\verifyotpMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




//pages

Route::get('/', [UserController::class, 'Login_page']);
Route::get('/signup', [UserController::class, 'signup_page']);


// Auth

Route::post('/createAccount', [UserController::class, 'createAccount']);
Route::post('/userLogin', [UserController::class, 'userLogin']);


Route::middleware([verifyotpMiddleware::class])->group(function () {

    Route::get('/index', [function(){
        return view('index');
    }])->name('index');

    Route::get('/number_details_page', [NumberDetailsController::class, 'index']);
    Route::get('/transaction_details_page', [TransactionDetailsController::class, 'index']);
    Route::get('/history_page', [HistoryController::class, 'historyPage']);
    Route::get('/payment_method_page', [PaymentMethodController::class, 'index']);
    Route::get('/account_type_page', [AccountTypeController::class, 'index']);
    Route::get('/customer_details_page', [CustomerDetailsController::class, 'index']);





//Post





// logout
// Route::get('/userLogout', [UserController::class, 'userLogout'])->middleware([verifyotpMiddleware::class]);


//numberDetails

Route::get('/number_details', [NumberDetailsController::class, 'Number_Details']);

Route::post('/number_details_by_id', [NumberDetailsController::class, 'Number_Details_By_Id']);

Route::post('/number_store', [NumberDetailsController::class, 'store']);

Route::post('/number_update', [NumberDetailsController::class, 'update']);


Route::post('/number_destroy', [NumberDetailsController::class, 'destroy']);

Route::post('/agent_number_details', [NumberDetailsController::class, 'AgentNumberDetails']);

//transactionDeails

Route::get('/transaction_details', [TransactionDetailsController::class, 'Transaction_Details']);

Route::post('/transaction_details_by_id', [TransactionDetailsController::class, 'Number_Details_By_Id']);

Route::post('/transaction_store', [TransactionDetailsController::class, 'store']);

Route::post('/transaction_update', [TransactionDetailsController::class, 'update']);


Route::post('/transaction_destroy', [TransactionDetailsController::class, 'destroy']);





//paymentDeails

Route::get('/payment_details', [PaymentMethodController::class, 'Payment_Details']);

Route::post('/payment_store', [PaymentMethodController::class, 'store']);

Route::post('/payment_update', [PaymentMethodController::class, 'update']);


Route::post('/payment_destroy', [PaymentMethodController::class, 'destroy']);



//CustomerDetails

Route::get('/customer_details', [CustomerDetailsController::class, 'customer_Details']);

Route::post('/customer_store', [CustomerDetailsController::class, 'store']);

Route::post('/customer_update', [CustomerDetailsController::class, 'update']);


Route::post('/customer_destroy', [CustomerDetailsController::class, 'destroy']);
Route::post('/customer_by_id', [CustomerDetailsController::class, 'cus_By_id']);



//Account type


Route::get('/account_type_details', [AccountTypeController::class, 'account_Details']);

Route::post('/account_type_store', [AccountTypeController::class, 'store']);

Route::post('/account_type_update', [AccountTypeController::class, 'update']);


Route::post('/account_type_destroy', [AccountTypeController::class, 'destroy']);




//history

Route::post('/historylist',[HistoryController::class,'HistoryList']);

Route::post('/history/download', [HistoryController::class, 'downloadHistory'])->name('history.download');



Route::post('/update-number-name', [NumberDetailsController::class, 'updateName']);

});






