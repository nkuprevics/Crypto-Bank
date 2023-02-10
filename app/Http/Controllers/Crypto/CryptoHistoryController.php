<?php

namespace App\Http\Controllers\Crypto;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\CryptoTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CryptoHistoryController extends Controller
{
    public function index(): View
    {
        return view('crypto/cryptoHistory')
            ->with('currentSelection', BankAccount::selectByNumber(request('account')))
            ->with('userAccounts', BankAccount::getAccountNumbers(Auth::id()))
            ->with('history', CryptoTransaction::getHistoryByAccount(request('account')));
    }

    public function filterDate(): View
    {

        $history = CryptoTransaction::filterTransactions
        (
            request('start_date'),
            request('end_date'),
            request('account')
        );

        return view('crypto/cryptoHistory')
            ->with('currentSelection', BankAccount::selectByNumber(request('account')))
            ->with('userAccounts', BankAccount::getAccountNumbers(Auth::id()))
            ->with('history', $history);
    }
}
