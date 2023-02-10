<?php

use App\Http\Controllers\Bank\BankAccountsController;
use App\Http\Controllers\Bank\EditCardController;
use App\Http\Controllers\Bank\HistoryController;
use App\Http\Controllers\Bank\TransferController;
use App\Http\Controllers\Crypto\CryptoHistoryController;
use App\Http\Controllers\Crypto\CryptoHomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', function () {
    return view('auth/login');
});

// Accounts

Route::get('/accounts', [BankAccountsController::class, 'index'])
    ->middleware('auth')
    ->name('accounts');

Route::get('/openAccount', [BankAccountsController::class, 'openAccount'])
    ->middleware('auth');

Route::delete('/closeAccount', [BankAccountsController::class, 'closeAccount'])
    ->middleware('auth');

// Edit Card Details

Route::get('/editCard/{cardNumber}', [EditCardController::class, 'index'])
    ->middleware('auth')
    ->name('editCard');

Route::patch('/updateBalance', [EditCardController::class, 'updateBalance'])
    ->middleware('auth')
    ->name('updateBalance');

Route::patch('/changeCurrency', [EditCardController::class, 'changeCurrency'])
    ->middleware('auth')
    ->name('changeCurrency');

Route::delete('/deleteCard', [EditCardController::class, 'deleteCard'])
    ->middleware('auth')
    ->name('deleteCard');

// Money Transfer

Route::get('/transfer', [TransferController::class, 'index'])
    ->middleware('auth')
    ->name('transfer');

Route::post('/transferMoney', [TransferController::class, 'transferMoney'])
    ->middleware('auth');

// Transaction History

Route::get('/history', [HistoryController::class, 'index'])
    ->middleware('auth')
    ->name('history');

Route::get('/filterDate', [HistoryController::class, 'filterDate'])
    ->middleware('auth')
    ->name('filterDate');

// Crypto Home

Route::get('/cryptoHome', [CryptoHomeController::class, 'index'])
    ->middleware('auth')
    ->name('crypto.index');

Route::post('/cryptoHome/buy', [CryptoHomeController::class, 'buy'])
    ->middleware('auth');

Route::post('/cryptoHome/sell', [CryptoHomeController::class, 'sell'])
    ->middleware('auth');

// Crypto History

Route::get('/cryptoHistory', [CryptoHistoryController::class, 'index'])
    ->middleware('auth')
    ->name('cryptoHistory.index');

Route::get('/cryptoHistory/filter', [CryptoHistoryController::class, 'filterDate'])
    ->middleware('auth');


