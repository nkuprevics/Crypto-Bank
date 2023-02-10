<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HistoryController extends Controller
{
    public function index():View
    {
        return view('bank/history')
            ->with('currentSelection', BankAccount::selectByNumber(request('account')))
            ->with('userAccounts', BankAccount::getAccountNumbers(Auth::id()))
            ->with('history', BankAccount::transactionHistory(request('account')));
    }

    public function filterDate():View
    {
        $history = Transaction::filterTransactions
        (
            request('start_date'),
            request('end_date'),
            request('account')
        );

        return view('bank/history')
            ->with('currentSelection', BankAccount::selectByNumber(request('account')))
            ->with('userAccounts', BankAccount::getAccountNumbers(Auth::id()))
            ->with('history', $history);
    }
}
