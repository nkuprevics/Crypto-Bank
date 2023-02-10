<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Http\Requests\MoneyTransactionRequest;
use App\Models\BankAccount;
use App\Services\MoneyTransactionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TransferController extends Controller
{
    private MoneyTransactionService $moneyTransactionService;

    public function __construct(MoneyTransactionService $moneyTransactionService)
    {
        $this->moneyTransactionService = $moneyTransactionService;
    }

    public function index(): View
    {
        return view('bank/transfer')
            ->with('userAccounts', BankAccount::getAccountNumbers(Auth::id()))
            ->with('selectedAccount', BankAccount::selectByNumber(request('account')));
    }

    public function transferMoney(MoneyTransactionRequest $request): RedirectResponse
    {
        $this->moneyTransactionService->transferMoney($request->all());

        return redirect('transfer')
            ->with('status', 'The money has been successfully transferred.');
    }
}
